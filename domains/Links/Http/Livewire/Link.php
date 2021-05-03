<?php

namespace Domains\Links\Http\Livewire;

use App\Actions\ChecksEmailHasGravatar;
use Illuminate\Support\Str;
use Livewire\Component;

class Link extends Component
{
    public $link;
    public $gravatar;

    public function render()
    {
        return view('livewire.link');
    }

    public function mount(): void
    {
        $this->gravatar = resolve(ChecksEmailHasGravatar::class)($this->link['author_email']);
        Str::startsWith($this->link['cover_image'], 'https://')
            ? $this->link
            : config('laravel-portugal.api_url') . '/' . $this->link['cover_image'];
    }
}
