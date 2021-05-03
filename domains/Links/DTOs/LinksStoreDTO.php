<?php

namespace Domains\Links\DTOs;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class LinksStoreDTO extends DataTransferObject
{
    public string $link;
    public string $title;
    public string $description;
    public string $author_name;
    public string $author_email;
    public string $cover_image;
    public array $tags;
}
