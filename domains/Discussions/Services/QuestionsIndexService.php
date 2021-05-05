<?php

namespace Domains\Discussions\Services;

use Carbon\CarbonInterface;
use Domains\Discussions\Models\Question;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class QuestionsIndexService
{
    protected array $filters = [];
    protected int $perPage = 15;
    protected int $currentPage = 1;

    public function withFilters(
        ?string $author,
        ?string $title,
        ?CarbonInterface $createdFrom,
        ?CarbonInterface $createdTo,
        ?bool $resolved
    ): self
    {
        $this->filters['author'] = $author ?? null;
        $this->filters['title'] = $title ?? null;
        $this->filters['createdFrom'] = $createdFrom ?? null;
        $this->filters['createdTo'] = $createdTo ?? null;
        $this->filters['resolved'] = $resolved ?? null;

        return $this;
    }

    public function paginated(int $currentPage, ?int $perPage = null): self
    {
        $this->perPage = $perPage ?? $this->perPage;
        $this->currentPage = $currentPage;

        return $this;
    }

    public function __invoke(): Paginator
    {
        return Question::withCount('answers')
            ->when($this->filters['author'] ?? null,
                fn (Builder $query, int $authorId) => $query->findByAuthorId($authorId))
            ->when($this->filters['title'] ?? null,
                fn (Builder $query, string $title) => $query->findByTitle($title))
            ->when($this->filters['created'] ?? null,
                fn (Builder $query, array $created) => $query->findByCreatedDate([
                    $this->filters['createdFrom'],
                    $this->filters['createdTo'],
                ]))
            ->when($this->filters['resolved'] ?? null,
                fn (Builder $query) => $query->resolved())
            ->when(($this->filters['resolved'] ?? null) === false,
                fn (Builder $query) => $query->unResolved())
            ->latest()
            ->simplePaginate(
                perPage: $this->perPage,
                page: $this->currentPage
            );
    }
}
