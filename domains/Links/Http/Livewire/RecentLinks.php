<?php

namespace Domains\Links\Http\Livewire;

use App\Http\Clients\ApiClient;
use Livewire\Component;

class RecentLinks extends Component
{
    public array $links;
    // Protected
    protected string $title = 'Links recentes.';
    protected string $description = 'Todos juntos criamos diariamente um base de conhecimento.';
    protected ApiClient $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = resolve(ApiClient::class);
    }

    public function mount()
    {
        $this->links = $this->client->getRecentLinks()['data'];
    }

    public function render()
    {
        return view('livewire.recent-links', [
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }
}
