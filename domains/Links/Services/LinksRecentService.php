<?php

namespace Domains\Links\Services;

use Domains\Links\Models\Link;
use Illuminate\Database\Eloquent\Builder;

class LinksRecentService
{
    protected Link $link;
    protected ?array $includes = null;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function with(array $includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    public function __invoke()
    {
        return $this->link
            ->when($this->includes, function (Builder $query) {
                return $query->with($this->includes);
            })
            ->approved()
            ->simplePaginate();
    }
}
