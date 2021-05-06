<?php

namespace Domains\Discussions\Http\Livewire;

use Domains\Discussions\DiscussionsServiceProvider;
use Domains\Discussions\Services\QuestionsIndexService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionsIndex extends Component
{
    use WithPagination;

    public ?bool $editMode = false;
    public int $perPage;

    public function mount(int $perPage = 15): void
    {
        $this->perPage = $perPage;
    }

    public function render(): View
    {
        $paginator = $this->search();

        return view(DiscussionsServiceProvider::getName() . '::livewire.questions-index', [
            'questions' => $paginator->items(),
            'paginator' => $paginator,
        ]);
    }

    public function search(): Paginator
    {
        return (new QuestionsIndexService())
//            ->withFilters(author: 'tiago', resolved: true, etc)
            ->paginated(currentPage: $this->page, perPage: $this->perPage)
            ->__invoke();
    }
}
