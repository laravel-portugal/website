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
    public string $url;
    public string $title;
    public string $description;
    public ?UploadedFile $cover_image;
    public ?array $tags;
    public LinkStatusType $status;

    /**
     * From a Request to DTO
     *
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $request): LinkUpdateDataDTO
    {
        return static::fromArray($request->all());
    }

    /**
     * From Array to DTO
     *
     * @param array $data
     * @param Link|null $link
     * @return static
     * @throws UnknownProperties
     */
    public static function fromArray(array $data, ?Link $link = null): static
    {
        $data = collect($link?->toArray() ?? [])->merge($data);

        return new static([
            'url' => $data->get('url'),
            'title' => $data->get('title'),
            'description' => $data->get('description'),
            'cover_image' => $data->get('cover_image'),
            'tags' => $data->get('tags'),
            'status' => LinkStatusType::attemptFrom($data->get('status', LinkStatusType::waiting_approval()))
        ]);
    }

    /**
     * Shortcut to update a single attribute
     *
     * @param Link $link
     * @param string|int|LinkStatusType $status
     * @return static
     * @throws UnknownProperties
     */
    public static function fromStatus(Link $link, string|int|LinkStatusType $status): static
    {
        return static::fromArray(['status' => $status], $link);
    }
}
