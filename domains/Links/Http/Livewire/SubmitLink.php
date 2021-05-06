<?php

namespace Domains\Links\Http\Livewire;

use Domains\Links\Exceptions\UnapprovedLinkLimitReachedException;
use Domains\Links\Http\Crawlers\OpenGraphMetaCrawler;
use Domains\Links\LinksServiceProvider;
use Domains\Links\Services\LinksStoreService;
use Domains\Tags\Http\Controllers\TagsIndexController;
use Domains\Tags\Services\TagsIndexService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Browsershot\Browsershot;

class SubmitLink extends Component
{
    use WithFileUploads;

    public $title;
    public $author_name;
    public $author_email;
    public $link;
    public $description;
    public $tags;
    public $availableTags;
    public $response;
    public $photo;
    public $generatedPhoto;
    protected OpenGraphMetaCrawler $crawler;
    protected array $config;
    protected array $messages = [
        'link.required' => 'É necessário indicar um endereço URL.',
        'link.url' => 'O endereço URL tem de ter a forma <protocolo>://<host><uri>, por exemplo https://www.google.com',
        'link.active_url' => 'O servidor/hostname indicado no endereço URL não existe.',
        'title.required' => 'É necessário indicar um título para o registo.',
        'name.required' => 'É necessário indicar um nome para associar ao registo.',
        'email.required' => 'É necessário indicar um e-mail para associar ao registo.',
        'email.email' => 'O e-mail tem de ser válido.',
        'description.required' => 'Coloque uma descrição no registo.',
        'tags.required' => 'Classifique o registo com uma etiqueta.',
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->config = config('laravel-portugal.links');
        $this->crawler = new OpenGraphMetaCrawler();
    }

    public function mount(): void
    {
        $this->availableTags = (new TagsIndexService())();
        $this->author_email = Auth::user()?->email;
        $this->author_name = Auth::user()?->name;
    }

    public function updatedWebsite(): void
    {
        $this->validate([
            'link' => $this->getRules()['link'],
        ]);
    }

    public function generateCoverImage(): void
    {
        $this->generatedPhoto = $this->getOGImage() ?? $this->getBrowserShotImage();
        $this->emit('photo:update');
    }

    public function clearPhoto(): void
    {
        $this->photo = null;
    }

    public function submit(): void
    {
        $this->validate($this->getRules());

        if ($this->photo) {
            // if it is a user-uploaded photo
            $photo = $this->photo->storePublicly('cover_images');
        }

        try {
            (new LinksStoreService)
                ->withInputs(
                    link: $this->link,
                    title: $this->title,
                    description: $this->description,
                    author_name: $this->author_name,
                    author_email: $this->author_email,
                    cover_image: $photo ?? $this->generatedPhoto,
                    tags: $this->tags,
                )
                ->__invoke();
        } catch (UnapprovedLinkLimitReachedException) {
        }
    }

    public function render(): View
    {
        return view(LinksServiceProvider::getName() . '::livewire.submit-link');
    }

    protected function getRules(): array
    {
        return (new LinksStoreService)->getRules();
    }

    protected function getOGImage(): ?string
    {
        $img = $this->crawler
            ->crawl($this->link)
            ->getOGImage();

        if (!$img) {
            return null;
        }

        $targetFile = $this->config['storage']['path'] . '/' . uniqid('', true) . '.' . $this->config['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);
        try {
            Storage::disk('public')->makeDirectory($this->config['storage']['path']);
            Storage::disk('public')->put($targetPath, file_get_contents($img));

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }

    protected function getBrowserShotImage(): ?string
    {
        $targetFile = $this->config['storage']['path'] . '/' . uniqid('', true) . '.' . $this->config['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);

        try {
            Storage::disk('public')
                ->makeDirectory($this->config['storage']['path']);

            Browsershot::url($this->link)
                ->dismissDialogs()
                ->ignoreHttpsErrors()
                ->setScreenshotType(
                    $this->config['cover_image']['format'],
                    $this->config['cover_image']['quality']
                )
                ->windowSize(
                    $this->config['cover_image']['size']['w'],
                    $this->config['cover_image']['size']['h']
                )
                ->save($targetPath);

            return $targetFile;
        } catch (\Exception) {
            return null;
        }
    }
}
