<?php

namespace Domains\Links\Http\Livewire;

use Domains\Links\DTOs\LinksStoreDTO;
use Domains\Links\Http\Crawlers\OpenGraphMetaCrawler;
use Domains\Links\Http\Requests\LinksStoreRequest;
use Domains\Links\LinksServiceProvider;
use Domains\Links\Services\LinksStoreService;
use Domains\Tags\Http\Controllers\TagsIndexController;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Browsershot\Browsershot;

class SubmitLink extends Component
{
    use WithFileUploads;

    public $title;
    public $name;
    public $email;
    public $website;
    public $description;
    public $tags;
    public $availableTags;
    public $response;
    public $photo;
    public $generatedPhoto;
    protected OpenGraphMetaCrawler $crawler;
    protected array $config;
    protected array $messages = [
        'website.required' => 'É necessário indicar um endereço URL.',
        'website.url' => 'O endereço URL tem de ter a forma <protocolo>://<host><uri>, por exemplo https://www.google.com',
        'website.active_url' => 'O servidor/hostname indicado no endereço URL não existe.',
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
        $this->availableTags = app(TagsIndexController::class)()
            ->resolve();
    }

    public function updatedWebsite(): void
    {
        $this->validate([
            'website' => $this->getRules()['website'],
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

        $tags = collect($this->tags)
            ->filter()
            ->map(fn ($tag) => ['id' => $tag])
            ->all();

        if ($this->photo) {
            $photo = Storage::path($this->photo->store('cover_images_photo'));
        } else if ($this->generatedPhoto) {
            $photo = Storage::path($this->generatedPhoto->store('cover_images_photo'));
        }

        $this->response = app(LinksStoreService::class)
            ->__invoke(
                new LinksStoreDTO([
                    'title' => $this->title,
                    'author_name' => $this->name,
                    'author_email' => $this->email,
                    'link' => $this->website,
                    'description' => $this->description,
                    'tags' => $tags,
                    'cover_image' => $photo ?? $this->generatedPhoto,
                ])
            );
    }

    public function render(): View
    {
        return view(LinksServiceProvider::getName() . '::livewire.submit-link');
    }

    protected function getRules(): array
    {
        return (new LinksStoreRequest())->rules();
    }

    protected function getOGImage()
    {
        return $this->crawler
            ->crawl($this->website)
            ->getOGImage();
    }

    protected function getBrowserShotImage(): ?string
    {
        $targetFile = $this->config['storage']['path'] . '/' . uniqid('', true) . '.' . $this->config['cover_image']['format'];
        $targetPath = Storage::disk('public')->path($targetFile);

        $img = null;
        try {
            Storage::disk('public')
                ->makeDirectory($this->config['storage']['path']);

            Browsershot::url($this->website)
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

            return URL::to($targetFile);
        } catch (Exception $exception) {
            return null;
        }
    }
}
