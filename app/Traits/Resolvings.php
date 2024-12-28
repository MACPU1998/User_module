<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Resolvings
{
    private function resolve($filterName, $values)
    {
        /*if (auth()->check()) {
            $array = explode('\\', get_class(auth()->user()));
            $filterName = end($array) . '_' . $filterName;
        }*/

        $methodName = lcfirst(Str::studly('filter_' . $filterName));

        if ($this->isCustomFilter($methodName) && $this->validateCustomFilter($values)) {
            return $this->resolveCustomFilter($methodName, $values);
        }

        $availableFilter = $this->availableFilters[$filterName] ?? $this->availableFilters['default'];

        return app($availableFilter, ['filter' => $filterName, 'values' => $values]);
    }

    private function resolveCustomFilter($filterName, $values)
    {
        return $this->getClosure($this->makeCallable($filterName), $values);
    }

    private function makeCallable($filter)
    {
        return static::class . '@' . $filter;
    }

    private function isCustomFilter($filterName)
    {
        return method_exists($this, $filterName);
    }

    private function getClosure($callable, $values)
    {
        return function ($query, $nextFilter) use ($callable, $values) {
            return app()->call($callable, ['query' => $nextFilter($query), 'value' => $values]);
        };
    }


    private function validateCustomFilter($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (count(separateCommaValues($value)) < 1) {
            return false;
        }

        return true;
    }
}
