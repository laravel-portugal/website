<?php

namespace Domains\Links\Services;

use Domains\Links\DTOs\LinksStoreDTO;
use Domains\Links\Models\Link;
use Illuminate\Support\Facades\Auth;

class LinksStoreService
{
    public function __invoke(LinksStoreDTO $data)
    {
        $user = Auth::user();

        $link = Link::create([
            'link' => $data->website,
            'title' => $data->title,
            'description' => $data->description,
            'author_name' => $user->name ?? $data->author_name,
            'author_email' => $user->email ?? $data->author_email,
            'cover_image' => $data->cover_image,
        ]);

        $link->tags()->attach($data->tags);
    }
}
