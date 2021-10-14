<?php

namespace App\DataTransferObjects;

use App\Http\Requests\StoreLinkRequest;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LinkStoreDataDTO extends DataTransferObject
{
    public string $url;
    public string $title;
    public string $description;
    public UploadedFile $cover_image;
    public array $tags;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(StoreLinkRequest $request): LinkStoreDataDTO
    {
        return new static($request->safe([
            'url',
            'title',
            'description',
            'cover_image',
            'tags',
        ]));
    }
}
