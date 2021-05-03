<?php

namespace Domains\Links;

use Domains\Links\Models\Link;
use Domains\Links\Observers\LinkObserver;
use Domains\Links\Policies\LinkPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LinksServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->bootRoutes();
        $this->bootPolicies();
    }

    private function bootRoutes(): void
    {
        Route::middleware('api')
            ->group(__DIR__ . '/routes.php');
    }

    private function bootPolicies(): void
    {
        Gate::policy(Link::class, LinkPolicy::class);
    }
}
