<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpdateTagRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagUpdateDataDTO extends DataTransferObject
{
    public string $name;
    public string $slug;
    public string $description;
    public string $color;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(UpdateTagRequest $request): TagUpdateDataDTO
    {
        return new static($request->safe([
            'name',
            'slug',
            'description',
            'color',
        ]));
    }
}
