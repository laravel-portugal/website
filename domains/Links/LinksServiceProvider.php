<?php

namespace Domains\Links;

use App\Links\Http\Livewire\Link;
use Domains\Links\Http\Livewire\RecentLinks;
use Domains\Links\Http\Livewire\SubmitLink;
use Domains\Support\BaseServiceProvider;

class LinksServiceProvider extends BaseServiceProvider
{
    protected string $name = 'links';
    protected array $livewireComponents = [
        'link' => Link::class,
        'recent-link' => RecentLinks::class,
        'submit-link' => SubmitLink::class,
    ];
}
