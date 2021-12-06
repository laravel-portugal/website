<?php

namespace App\Providers;

use App\Helpers\Extensions\Paginator;
use App\Helpers\Extensions\Ssr;
use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::register();
        Ssr::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $this->registerMorphs();
    }

    /**
     * Register and enforce Morph Maps.
     */
    protected function registerMorphs()
    {
        Relation::requireMorphMap();
        Relation::enforceMorphMap([
            'user' => User::class,
            'tag' => Tag::class,
            'link' => Link::class,
        ]);
    }
}
