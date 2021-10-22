<?php

namespace App\DataTransferObjects;

use App\Http\Requests\StoreTagRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagStoreDataDTO extends DataTransferObject
{
    public string $name;
    public string $slug;
    public string $description;
    public string $color;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(StoreTagRequest $request): TagStoreDataDTO
    {
        return new static($request->safe([
            'name',
            'slug',
            'description',
            'color',
        ]));
    }
}
