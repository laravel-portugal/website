<?php

namespace App\Actions;

use App\DataTransferObjects\TagUpdateDataDTO;
use App\Models\Tag;

class TagUpdateAction
{
    public static function execute(Tag $tag, TagUpdateDataDTO $data)
    {
        $tag->forceFill($data->toArray());
        $tag->slug = \Str::slug($tag->name);
        $tag->save();
    }
}
