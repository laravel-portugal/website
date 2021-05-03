<?php

namespace Domains\Accounts;

use Domains\Accounts\Middleware\RedirectIfAuthenticated;
use GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'accounts');
        $this->bootRoutes();
    }

    private function bootRoutes(): void
    {
        Route::group(
            [
                'middleware' => 'api',
                'prefix' => 'accounts',
                'as' => 'accounts',
            ],
            fn () => $this->loadRoutesFrom(__DIR__ . '/routes.php')
        );
    }
}
