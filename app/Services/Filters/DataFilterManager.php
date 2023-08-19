<?php

namespace App\Services\Filters;

use App\Services\Interfaces\FilterInterface;
use Illuminate\Http\Request;

class DataFilterManager {
    private array $filters = [];

    /**
     * Add a filter to the context.
     *
     * @param FilterInterface $filter The filter to be added.
     */
    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * Apply filters to the given data.
     *
     * @param array $data The data to be filtered.
     * @param Request $request The incoming HTTP request.
     * @return array The filtered data.
     */
    public function filter(array $data, Request $request): array
    {
        foreach ($this->filters as $filter) {
            $data = $filter->filter($data, $request);
        }
        return $data;
    }
}
