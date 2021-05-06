<?php

namespace Domains\Links\Http\Livewire;

use Domains\Links\Exceptions\UnapprovedLinkLimitReachedException;
use Domains\Links\LinksServiceProvider;
use Domains\Links\Services\LinksCoverImageService;
use Domains\Links\Services\LinksStoreService;
use Domains\Tags\Services\TagsIndexService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

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

    public function mount(): void
    {
        $this->availableTags = (new TagsIndexService())();
        $this->author_email = Auth::user()?->email;
        $this->author_name = Auth::user()?->name;
    }

    /**
     * @throws ValidationException
     */
    public function updatedLink(): void
    {
        $this->validateOnly('link');
    }

    public function generateCoverImage(): void
    {
        $this->generatedPhoto = (new LinksCoverImageService())
            ->forLink($this->link)
            ->__invoke();

        $this->emit('photo:update');
    }

    public function clearPhoto(): void
    {
        $this->photo = null;
    }

    public function submit(): void
    {
        $this->validate();

        if ($this->photo) {
            // if it is a user-uploaded photo, we store it at this point.
            $photo = $this->photo->storePublicly('cover_images');
        }

        try {
            $link = (new LinksStoreService)
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

            if ($link) {
                session()->flash('message', __('Link submitted.'));
                $this->redirectRoute(LinksServiceProvider::getName() . '::index');
            } else {
                session()->flash('message', __('We could not submit you Link.'));
            }
        } catch (UnapprovedLinkLimitReachedException $exception) {
            session()->flash('message', __($exception->getMessage()));
        }
    }

    public function render(): View
    {
        return view(LinksServiceProvider::getName() . '::livewire.submit-link');
    }

    protected function rules(): array
    {
        return (new LinksStoreService)->getRules();
    }
}
