<?php

namespace App\QueryBuilders;

use App\Models\Link;
use App\Types\LinkStatusType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LinkQueryBuilder  extends Builder
{
    public function applySearchAndSmartFilter(Request $request): LinkQueryBuilder
    {
        return $this
            ->applySearch($request->get('q',''))
            ->applySmartFilters($request->get('smart_filter', ''));
    }

    public function applySearch(string $searchQuery = ''): LinkQueryBuilder
    {
        $shouldSearch = null !== $searchQuery && strlen($searchQuery) > 1;
        return $this->when($shouldSearch, function ($query) use ($searchQuery) {
            /* @var Builder|Link $query */
            return $query->search($searchQuery, null, true, true);
        });
    }

    public function applySmartFilters(string $name = ''): LinkQueryBuilder
    {
        /** @var Builder|Link $query */
        $availableSorting = [
            'status-published',
            'status-rejected',
            'status-waiting-approval',
            'updated-asc',
            'created-desc',
        ];

        $isValidSorting = in_array($name, $availableSorting);
        $shouldApply = null !== $name && $isValidSorting;

        // Sorting is not valid
        if (! $shouldApply) {
            return $this;
        }

        // Published with oldest
        if ('status-published' === $name) {
            return $this
                ->where('status',LinkStatusType::published()->value)
                ->latest();
        }

        // Rejected with oldest
        if ('status-rejected' === $name) {
            return $this
                ->where('status',LinkStatusType::rejected()->value)
                ->latest();
        }

        // Published with oldest
        if ('status-waiting-approval' === $name) {
            return $this
                ->where('status',LinkStatusType::waiting_approval()->value)
                ->oldest();
        }

        // Published with oldest
        if ('updated-desc' === $name) {
            return $this->oldest('updated_at');
        }

        // Published with oldest
        if ('created-desc' === $name) {
            return $this->oldest('created_at');
        }

        return $this;
    }

}
