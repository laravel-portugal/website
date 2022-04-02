<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function mb_strtolower;

/**
 * Trait SearchableTrait.
 *
 * @property array  $searchable
 * @property string $table
 * @property string $primaryKey
 *
 * @method string getTable()
 */
trait HasSearch
{
    protected array $search_bindings = [];
    // protected array $searchable = [];

    /**
     * Creates the search scope.
     */
    public function scopeSearch(Builder $q, string $search, ?float $threshold = null, bool $entireText = false, bool $entireTextOnly = false): Builder
    {
        return $this->scopeSearchRestricted($q, $search, null, $threshold, $entireText, $entireTextOnly);
    }

    public function scopeSearchRestricted(Builder $q, string $search, ?float $restriction, ?float $threshold = null, bool $entireText = false, bool $entireTextOnly = false): Builder
    {
        if (empty($search)) {
            return $q;
        }

        $query = clone $q;
        $query->select($this->getTable().'.*');
        $this->makeJoins($query);

        $search = mb_strtolower(trim($search));
        preg_match_all('/(?:")((?:\\\\.|[^\\\\"])*)(?:")|(\S+)/', $search, $matches);
        $words = $matches[1];
        for ($i = 2; $i < count($matches); $i++) {
            $words = array_filter($words) + $matches[$i];
        }

        $selects = [];
        $this->search_bindings = [];
        $relevance_count = 0;

        foreach ($this->getColumns() as $column => $relevance) {
            $relevance_count += $relevance;

            if (! $entireTextOnly) {
                $queries = $this->getSearchQueriesForColumn($column, $relevance, $words);
            } else {
                $queries = [];
            }

            if ((true === $entireText && count($words) > 1) || true === $entireTextOnly) {
                $queries[] = $this->getSearchQuery($column, $relevance, [$search], 50, '', '');
                $queries[] = $this->getSearchQuery($column, $relevance, [$search], 30, '%', '%');
            }

            foreach ($queries as $select) {
                if (! empty($select)) {
                    $selects[] = $select;
                }
            }
        }

        $this->addSelectsToQuery($query, $selects);

        // Default the threshold if no value was passed.
        $columns = $this->getColumns();
        if (is_null($threshold) && ! empty($columns)) {
            $threshold = $relevance_count / count($columns);
        }

        if (! empty($selects)) {
            $this->filterQueryWithRelevance($query, $selects, $threshold);
        }

        $this->makeGroupBy($query);

        if (is_callable($restriction)) {
            $query = $restriction($query);
        }

        $this->mergeQueries($query, $q);

        return $q;
    }

    /**
     * Returns database driver Ex: mysql, pgsql, sqlite.
     */
    protected function getDatabaseDriver(): string
    {
        $key = $this->connection ?: Config::get('database.default');

        return Config::get('database.connections.'.$key.'.driver');
    }

    /**
     * Returns the search columns.
     */
    protected function getColumns(): array
    {
        if (array_key_exists('columns', $this?->searchable ?? [])) {
            $driver = $this->getDatabaseDriver();
            $prefix = Config::get("database.connections.$driver.prefix");
            $columns = [];
            foreach ($this->searchable['columns'] as $column => $priority) {
                $columns[$prefix.$column] = $priority;
            }

            return $columns;
        } else {
            return DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
        }
    }

    /**
     * Returns whether to keep duplicates.
     */
    protected function getGroupBy(): array
    {
        if (array_key_exists('groupBy', $this?->searchable ?? [])) {
            return $this->searchable['groupBy'];
        }

        return [];
    }

    /**
     * Returns the table columns.
     */
    public function getTableColumns(): array
    {
        return $this?->searchable['table_columns'] ?? [];
    }

    /**
     * Returns the tables that are to be joined.
     */
    protected function getJoins(): array
    {
        return Arr::get($this?->searchable, 'joins', []) ?? [];
    }

    /**
     * Adds the sql joins to the query.
     */
    protected function makeJoins(Builder $query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
                if (array_key_exists(2, $keys) && array_key_exists(3, $keys)) {
                    $join->whereRaw($keys[2].' = "'.$keys[3].'"');
                }
            });
        }
    }

    /**
     * Makes the query not repeat the results.
     */
    protected function makeGroupBy(Builder $query)
    {
        if (! empty($this->getGroupBy()) && $groupBy = $this->getGroupBy()) {
            $query->groupBy($groupBy);
        } else {
            if ($this->isSqlsrvDatabase()) {
                $columns = $this->getTableColumns();
            } else {
                $columns = $this->getTable().'.'.$this->primaryKey;
            }

            $query->groupBy($columns);

            $joins = array_keys(($this->getJoins()));

            foreach ($this->getColumns() as $column => $relevance) {
                array_map(function ($join) use ($column, $query) {
                    if (Str::contains($column, $join)) {
                        $query->groupBy($column);
                    }
                }, $joins);
            }
        }
    }

    /**
     * Puts all the select clauses to the main query.
     */
    protected function addSelectsToQuery(Builder $query, array $selects)
    {
        if (! empty($selects)) {
            $query->selectRaw('max('.implode(' + ', $selects).') as '.$this->getRelevanceField(), $this->search_bindings);
        }
    }

    /**
     * Adds the relevance filter to the query.
     */
    protected function filterQueryWithRelevance(Builder $query, array $selects, float|string $relevance_count)
    {
        $comparator = $this->isMysqlDatabase() ? $this->getRelevanceField() : implode(' + ', $selects);

        $relevance_count = number_format($relevance_count, 2, '.', '');

        if ($this->isMysqlDatabase()) {
            $bindings = [];
        } else {
            $bindings = $this->search_bindings;
        }
        $query->havingRaw("$comparator >= $relevance_count", $bindings);
        $query->orderBy($this->getRelevanceField(), 'desc');

        // add bindings to postgres
    }

    /**
     * Returns the search queries for the specified column.
     */
    protected function getSearchQueriesForColumn(string $column, float|string $relevance, array $words): array
    {
        return [
            $this->getSearchQuery($column, $relevance, $words, 15),
            $this->getSearchQuery($column, $relevance, $words, 5, '', '%'),
            $this->getSearchQuery($column, $relevance, $words, 1, '%', '%'),
        ];
    }

    /**
     * Returns the sql string for the given parameters.
     */
    protected function getSearchQuery(string $column, string $relevance, array $words, float|string $relevance_multiplier, string $pre_word = '', string $post_word = ''): string
    {
        $like_comparator = $this->isPostgresqlDatabase() ? 'ILIKE' : 'LIKE';
        $cases = [];

        foreach ($words as $word) {
            $cases[] = $this->getCaseCompare($column, $like_comparator, $relevance * $relevance_multiplier);
            $this->search_bindings[] = $pre_word.$word.$post_word;
        }

        return implode(' + ', $cases);
    }

    /**
     * Returns the comparison string.
     *
     * @return string
     */
    protected function getCaseCompare(string $column, string $compare, float|string $relevance)
    {
        if ($this->isPostgresqlDatabase()) {
            $field = 'LOWER('.$column.') '.$compare.' ?';

            return '(case when '.$field.' then '.$relevance.' else 0 end)';
        }

        $column = str_replace('.', '`.`', $column);
        $field = 'LOWER(`'.$column.'`) '.$compare.' ?';

        return '(case when '.$field.' then '.$relevance.' else 0 end)';
    }

    /**
     * Merge our cloned query builder with the original one.
     */
    protected function mergeQueries(Builder $clone, Builder $original)
    {
        $tableName = DB::connection($this->connection)->getTablePrefix().$this->getTable();
        if ($this->isPostgresqlDatabase()) {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as {$tableName}"));
        } else {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as `{$tableName}`"));
        }

        // First create a new array merging bindings
        $mergedBindings = array_merge_recursive(
            $clone->getBindings(),
            $original->getBindings()
        );

        // Then apply bindings WITHOUT global scopes which are already included. If not, there is a strange behaviour
        // with some scope's bindings remaining
        $original->withoutGlobalScopes()->setBindings($mergedBindings);
    }

    /**
     * Returns the relevance field name, alias of ratio column in the query.
     */
    protected function getRelevanceField(): string
    {
        if ($this?->relevanceField ?? false) {
            return $this?->relevanceField;
        }

        // If property $this->relevanceField is not setted, return the default
        return 'relevance';
    }

    /**
     * Check if used database is MySQL.
     */
    private function isMysqlDatabase(): bool
    {
        return 'mysql' == $this->getDatabaseDriver();
    }

    /**
     * Check if used database is PostgreSQL.
     */
    private function isPostgresqlDatabase(): bool
    {
        return 'pgsql' == $this->getDatabaseDriver();
    }

    /**
     * Check if used database is SQLSRV.
     */
    protected function isSqlsrvDatabase(): bool
    {
        return 'sqlsrv' == $this->getDatabaseDriver();
    }
}
