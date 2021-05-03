<?php
declare(strict_types=1);

namespace Domains\Links\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LinksStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'link' => ['required', 'string', 'url'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'author_name' => ['required', 'string'],
            'author_email' => ['required', 'email', Auth::id() ? null : 'unique:users,email'],
            'cover_image' => ['required', 'image'],
            'tags' => ['required', 'array'],
            'tags.*.id' => ['required', 'integer', 'exists:tags'],
        ];
    }
}
