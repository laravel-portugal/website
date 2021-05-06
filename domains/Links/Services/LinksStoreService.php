<?php

namespace Domains\Links\Services;

use Domains\Links\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LinksStoreService
{
    protected array $inputs;

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

    /**
     * @throws ValidationException
     */
    public function __invoke(): ?Link
    {
        $this->validate();

        $link = Link::create($this->inputs);
        if (!$link) {
            return null;
        }

        $link->tags()->attach($this->inputs['tags']);

        return $link;
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

    public function getMessages(): array
    {
        return [
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
    }

    /**
     * @throws ValidationException
     */
    protected function validate(): void
    {
        Validator::make($this->inputs, $this->getRules(), $this->getMessages())
            ->validated();
    }
}
