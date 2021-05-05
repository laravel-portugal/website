<?php

namespace Domains\Tags\Services;

use Domains\Tags\Models\Tag;

class TagsIndexService
{
    public function __invoke(): array
    {
        return Tag::all()
            ->toArray();
    }
}
