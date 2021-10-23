<?php

namespace App\Actions;

use App\DataTransferObjects\TagStoreDataDTO;
use App\Models\Tag;

class TagStoreAction
{
    public static function execute(TagStoreDataDTO $data)
    {
        $link = new Tag();
        $link->forceFill($data->toArray());
        $link->slug = \Str::slug($link->name);
        $link->save();
    }
}
