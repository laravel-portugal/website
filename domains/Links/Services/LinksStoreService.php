<?php

namespace Domains\Links\Services;

use Domains\Links\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LinksStoreService
{
    public array $inputs;

    public function withInputs(
        string $link,
        string $title,
        string $description,
        ?string $author_name = null,
        ?string $author_email = null,
        string $cover_image,
        array $tags,
    ): self
    {
        $this->inputs = get_defined_vars();

        $user = Auth::user();
        $this->inputs['author_name'] = $user?->name ?? $this->inputs['author_name'];
        $this->inputs['author_email'] = $user?->email ?? $this->inputs['author_email'];

        return $this;
    }

    public function getRules(): array
    {
        return [
            'link' => ['required', 'string', 'url'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'author_name' => ['required', 'string'],
            'author_email' => ['required', 'email', Auth::id() ? null : 'unique:users,email'],
            'tags' => ['required', 'array'],
            'tags.*' => ['required', 'integer', 'exists:tags,id'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function __invoke()
    {
        $this->validate();

        $link = Link::create($this->inputs);
        $link->tags()->attach($this->inputs['tags']);
    }

    /**
     * @throws ValidationException
     */
    protected function validate(): void
    {
        Validator::make($this->inputs, $this->getRules())
            ->validated();
    }
}
