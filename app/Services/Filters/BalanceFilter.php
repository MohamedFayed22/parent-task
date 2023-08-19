<?php

namespace App\Services\Filters;


use App\Services\Interfaces\FilterInterface;

class BalanceFilter implements FilterInterface
{
    /**
     * Filter data based on balance range.
     *
     * @param array $data The data to be filtered.
     * @param $request.
     * @return array The filtered data.
     */
    public function filter($data, $request): array
    {
        $balanceMin = $request->input('balanceMin');
        $balanceMax = $request->input('balanceMax');

        $filters = $this->defineFilters($balanceMin, $balanceMax);
        return $this->applyFilters($data, $filters);
    }

    /**
     * Define filters based on balance range.
     *
     * @param float|null $balanceMin The minimum amount value.
     * @param float|null $balanceMax The maximum amount value.
     * @return array An array of filter functions.
     */
    private function defineFilters(?float $balanceMin, ?float $balanceMax): array
    {
        $filters = [];

        if ($balanceMin !== null) {
            $filters[] = function ($item) use ($balanceMin) {
                return $item['amount'] >= $balanceMin;
            };
        }

        if ($balanceMax !== null) {
            $filters[] = function ($item) use ($balanceMax) {
                return $item['amount'] <= $balanceMax;
            };
        }

        return $filters;
    }

    /**
     * Apply filters to the data.
     *
     * @param array $data The data to be filtered.
     * @param array $filters An array of filter functions.
     * @return array The filtered data.
     */
    private function applyFilters(array $data, array $filters): array
    {
        foreach ($filters as $filter) {
            $data = array_filter($data, $filter);
        }

        return $data;
    }
}
