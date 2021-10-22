<?php

namespace App\Actions;

use App\Models\Link;
use Illuminate\Support\Facades\Storage;

class LinkDeleteAction
{
    public static function execute(Link $link, bool $force = false): ?bool
    {
        if($force){
            // Remove the photo
            if($link->cover_image){
                Storage::disk(Link::coverPhotosDisk())->delete($link->cover_image);
            }
            return $link->forceDelete();
        }
        return $link->delete();
    }
}
