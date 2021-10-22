<?php

namespace App\Actions;

use App\Models\Tag;

class TagDeleteAction
{
    public static function execute(Tag $tag, bool $force = false): ?bool
    {
        return $force ? $tag->forceDelete() : $tag->delete();
    }
}
