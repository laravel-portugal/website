<?php

namespace App\QueryBuilders;

use App\Models\Link;
use App\Types\LinkStatusType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LinkQueryBuilder extends Builder
{
    public function published(): LinkQueryBuilder
    {
        return $this->where('status', LinkStatusType::published()->value);
    }

    public function waitingApproval(): LinkQueryBuilder
    {
        return $this->where('status', LinkStatusType::waiting_approval()->value);
    }

    public function rejected(): LinkQueryBuilder
    {
        return $this->where('status', LinkStatusType::rejected()->value);
    }

    public function applySearchAndSmartFilter(Request $request, array $except = []): LinkQueryBuilder
    {
        // Ensure we filter it down
        $smartFilter = $request->input('filter', '');
        if (collect($except)->has($smartFilter)) {
            $smartFilter = '';
        }

        return $this
            ->applySearch($request->input('q', '') ?? '')
            ->applyAuthor($request->input('author', '') ?? '')
            ->applyTag($request->input('tag', '') ?? '')
            ->applySmartFilters($smartFilter ?? '');
    }

    public function applySearchAndSmartFilterRestricted(Request $request): LinkQueryBuilder
    {
        // Remove
        return $this
            ->applySearchAndSmartFilter($request, [
                'status-published',
                'status-rejected',
                'status-waiting-approval',
                'deleted',
            ]);
    }

    public function applyAuthor(string $authorSlug = '')
    {
        $shouldSearch = null !== $authorSlug && strlen($authorSlug) > 0;

        return $this->when($shouldSearch, function ($query) use ($authorSlug) {
            /* @var Builder|Link $query */
            return $query->whereHas('author', function (Builder $author) use ($authorSlug) {
                $author->where('id', $authorSlug);
            });
        });
    }

    public function applyTag(string $tagSlug = '')
    {
        $shouldSearch = null !== $tagSlug && strlen($tagSlug) > 0;

        return $this->when($shouldSearch, function ($query) use ($tagSlug) {
            /* @var Builder|Link $query */
            $query->whereHas('tags', function (Builder $tagsQuery) use ($tagSlug) {
                $tagsQuery->where('slug', $tagSlug);
            });
        });
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
            'deleted',
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
                ->published()
                ->latest();
        }

        // Rejected with oldest
        if ('status-rejected' === $name) {
            return $this
                ->rejected()
                ->latest();
        }

        // Published with oldest
        if ('status-waiting-approval' === $name) {
            return $this
                ->waitingApproval()
                ->oldest();
        }

        // Published with oldest
        if ('updated-desc' === $name) {
            return $this->latest('updated_at');
        }

        // Published with oldest
        if ('created-desc' === $name) {
            return $this->latest('created_at');
        }

        // Published with oldest
        if ('deleted' === $name) {
            return $this->whereNotNull('deleted_at');
        }

        return $this;
    }
}
