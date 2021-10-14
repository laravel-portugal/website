<?php

namespace App\Actions;

use App\DataTransferObjects\LinkStoreDataDTO;
use App\Models\Link;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Support\Facades\Storage;

class LinkStoreAction
{
    public static function execute(User $user, LinkStoreDataDTO $data)
    {
        $link = new Link();
        $link->fill($data->toArray());
        $link->author()->associate($user);

        // Create a unique short hash
        $link->hash = (new Hashids('link'))->encode(
            crc32($link->url),
            time(),
            ...array_values($data->tags)
        );

        // Upload the Photo
        tap($link->cover_image, function ($previous) use ($data, $link) {
            // Fill it
            $link->forceFill([
                'cover_image' => $data->cover_image->storePublicly(Link::coverPhotosFolder(), ['disk' => Link::coverPhotosDisk()]),
            ]);

            // Delete the previous
            if ($previous) {
                Storage::disk(Link::coverPhotosDisk())->delete($previous);
            }
        });

        $link->syncTags($data->tags);
    }
}
