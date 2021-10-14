<?php

namespace App\Actions;

use App\DataTransferObjects\LinkUpdateDataDTO;
use App\Models\Link;
use App\Types\LinkStatusType;
use Illuminate\Support\Facades\Storage;

class LinkUpdateAction
{
    public static function execute(Link $link, LinkUpdateDataDTO $data)
    {
        // Fill the user trusted data
        $link->fill($data->toArray());

        // Fill Admin only Data
        $link->forceFill($data->only('status')->toArray());

        // Link was published, update timestamp
        if ($link->isDirty('status') && $link->status->equals(LinkStatusType::published())) {
            $link->approved_at = now();
        }

        // Link was rejected
        if ($link->isDirty('status') && $link->status->equals(LinkStatusType::rejected())) {
            $link->rejected_at = now();
        }

        // Upload the Photo
        if (null !== $data->cover_image) {
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
        }

        $link->syncTags($data->tags);
    }
}
