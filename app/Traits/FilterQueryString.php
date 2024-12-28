<?php

namespace App\Traits;

use Illuminate\Pipeline\Pipeline;
use Mehradsadeghi\FilterQueryString\Filters\{OrderbyClause, WhereClause, WhereInClause, WhereLikeClause};
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\{GreaterOrEqualTo, GreaterThan, LessOrEqualTo, LessThan};
use Mehradsadeghi\FilterQueryString\Filters\ComparisonClauses\Between\{Between, NotBetween};

trait FilterQueryString
{

    use Resolvings;

    private $availableFilters = [
        'default' => WhereClause::class,
        'sort' => OrderbyClause::class,
    ];

    public function scopeFilter($query, ...$filters)
    {
        $filters = collect($this->getFilters($filters))->map(function ($values, $filter) {
            $resolved = $this->resolve($filter, $values);
            if ($resolved) return $resolved;
            return null;
        })->toArray();

        foreach ($filters as $key => $value)
            if ($value === null) unset($filters[$key]);

        return app(Pipeline::class)
            ->send($query)
            ->through($filters)
            ->thenReturn();
    }

    private function getFilters($filters)
    {
        $filter = function ($key) use ($filters) {

            $filters = $filters ?: $this->filters ?: [];

            return $this->unguardFilters != true ? in_array($key, $filters) : true;
        };

        return array_filter(request()->query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }
}
