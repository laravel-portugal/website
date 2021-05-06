<?php

namespace Domains\Tags\Services;

use Domains\Tags\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagsIndexService
{
    public function __invoke(): Collection
    {
        return Tag::all();
    }
}
