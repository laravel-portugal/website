<?php

namespace Domains\Tags\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Tags\Models\Tag;
use Domains\Tags\Resources\TagResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagsIndexController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return TagResource::collection(Tag::all());
    }
}
