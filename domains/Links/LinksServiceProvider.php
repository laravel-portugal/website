<?php

namespace Domains\Links;

use App\Providers\BaseServiceProvider;
use Domains\Links\Http\Livewire\RecentLinks;
use Domains\Links\Http\Livewire\SubmitLink;
use Domains\Links\Models\Link;
use Domains\Links\Models\Observers\LinkObserver;

class LinksServiceProvider extends BaseServiceProvider
{
    protected array $livewireComponents = [
        'link' => Link::class,
        'recent-links' => RecentLinks::class,
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
