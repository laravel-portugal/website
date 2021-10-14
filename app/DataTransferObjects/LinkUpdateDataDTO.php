<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Types\LinkStatusType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LinkUpdateDataDTO extends DataTransferObject
{
    public ?string $url;
    public ?string $title;
    public ?string $description;
    public ?UploadedFile $cover_image;
    public ?array $tags;
    public LinkStatusType $status;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): LinkUpdateDataDTO
    {
        return new static(
            array_merge(
                $request->safe([
                    'url',
                    'title',
                    'description',
                    'cover_image',
                    'tags',
                ]),
                [
                    'status' => LinkStatusType::attemptFrom($request->input('status', LinkStatusType::waiting_approval())),
                ]
            )
        );
    }

    /**
     * @param array $data
     * @param Link|null $link
     * @return static
     * @throws UnknownProperties
     */
    public static function fromArray(array $data, ?Link $link): static
    {
        return new static(array_merge($data,$link ? $link->toArray() : 0));
    }

    /**
     * Update the status of a link given the DTO
     * @param $status
     * @param Link|null $link
     * @return static
     * @throws UnknownProperties
     */
    public static function updateStatus($status, ?Link $link): static
    {
        return self::fromArray(['status' => $status, 'cover_image' => null],$link);
    }
}
