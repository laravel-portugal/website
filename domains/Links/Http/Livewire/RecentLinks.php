<?php

namespace Domains\Links\Http\Livewire;

use Domains\Links\LinksServiceProvider;
use Domains\Links\Services\LinksRecentService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecentLinks extends Component
{
    public array $links;
    public string $title = 'Links recentes.';
    public string $description = 'Todos juntos criamos diariamente uma base de conhecimento.';

    public function mount(): void
    {
        $this->links = app(LinksRecentService::class)()->items() ?? [];
    }

    public function render(): View
    {
        return view(LinksServiceProvider::getName() . '::livewire.recent-links');
    }
}
