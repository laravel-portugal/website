<?php

namespace Domains\Support;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

abstract class BaseServiceProvider extends ServiceProvider
{
    protected array $commands = [];
    protected array $bladeComponents = [];
    protected array $bladeComponentsNamespaces = [];
    protected array $observers = [];
    protected array $livewireComponents = [];
    protected ?string $kernel = null;
    private ?string $dir = null;

    abstract public static function getName(): string;

    protected function registerCrons(Schedule $schedule): void
    {
        // Override if needed
    }

    public function register(): void
    {
        $this->commands($this->commands);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom($this->getDir() . '/Database/Migrations');

        $this->bootRoutes();
        $this->bootObservers();
        $this->bootViews();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerConsoleKernel();
    }

    protected function bootRoutes(): void
    {
        $web = $this->getDir() . '/Http/web.php';
        if (file_exists($web)) {
            Route::middleware('web')
                ->group($web);
        }

        $api = $this->getDir() . '/Http/api.php';
        if (file_exists($api)) {
            Route::prefix('api')
                ->middleware(['api'])
                ->group($api);
        }
    }

    protected function bootObservers(): void
    {
        foreach ($this->observers as $model => $observer) {
            $model::observe($observer);
        }
    }

    protected function registerConsoleKernel(): void
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->registerCrons($schedule);
        });
    }

    protected function registerLivewireComponents(): void
    {
        foreach ($this->livewireComponents as $alias => $class) {
            Livewire::component($this->getAlias($alias), $class);
        }
    }

    protected function bootViews(): void
    {
        $this->loadViewsFrom($this->getDir() . '/Resources/Views', $this->name);
    }

    protected function registerBladeComponents(): void
    {
        foreach ($this->bladeComponentsNamespaces as $alias => $path) {
            Blade::componentNamespace($path, $this->getAlias($alias));
        }

        foreach ($this->bladeComponents as $alias => $path) {
            Blade::component($path, $this->getAlias($alias));
        }
    }

    private function getDir(): string
    {
        return $this->dir ?: dirname((new \ReflectionClass(static::class))->getFileName());
    }

    private function getAlias(string $alias): string
    {
        return static::getName() . '::' . $alias;
    }
}
