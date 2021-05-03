<?php

namespace Domains\Links;

use Domains\Links\Http\Livewire\RecentLinks;
use Domains\Links\Http\Livewire\SubmitLink;
use Domains\Links\Models\Link;
use Domains\Links\Models\Observers\LinkObserver;
use Domains\Support\BaseServiceProvider;

class LinksServiceProvider extends BaseServiceProvider
{
    protected string $name = 'links';
    protected array $livewireComponents = [
        'link' => Link::class,
        'recent-link' => RecentLinks::class,
        'submit-link' => SubmitLink::class,
    ];
    protected array $observers = [
        Link::class => LinkObserver::class,
    ];

    public static function getName(): string
    {
        return 'links';
    }
}
