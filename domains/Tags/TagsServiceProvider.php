<?php

namespace Domains\Tags;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TagsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        $this->bootRoutes();
    }

    private function bootRoutes(): void
    {
        Route::group(
            [
                'prefix' => 'tags',
                'as' => 'tags.',
            ],
            fn () => $this->loadRoutesFrom(__DIR__ . '/Http/routes.php')
        );
    }
}
