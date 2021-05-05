<?php

namespace Domains\Links\Services;

use Domains\Links\Models\Link;
use Illuminate\Contracts\Pagination\Paginator;

class LinksIndexService
{
    public function __invoke(): Paginator
    {
        return Link::with('tags')
            ->approved()
            ->simplePaginate();
    }
}
