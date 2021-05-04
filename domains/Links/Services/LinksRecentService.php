<?php

namespace Domains\Links\Services;

use Domains\Links\Models\Link;

class LinksRecentService
{
    protected Link $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function __invoke()
    {
        return $this->link
            ->approved()
            ->simplePaginate();
    }
}
