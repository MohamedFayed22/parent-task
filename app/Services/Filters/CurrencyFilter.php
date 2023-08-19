<?php

namespace App\Services\Filters;


use App\Services\Interfaces\FilterInterface;

class CurrencyFilter implements FilterInterface
{
    /**
     * Filter data based on currency.
     *
     * @param array $data The data to be filtered.
     * @param $request.
     * @return array The filtered data.
     */
    public function filter($data, $request): array
    {
        $currency = $request->input('currency');

        if ($currency === null) {
            return $data; // No filtering needed, return original data
        }

        return $this->applyCurrencyFilter($data, $currency);
    }

    /**
     * Apply currency filter to the data.
     *
     * @param array $data The data to be filtered.
     * @param string $currency The currency to filter by.
     * @return array The filtered data.
     */
    private function applyCurrencyFilter(array $data, string $currency): array
    {
        return array_filter($data, function($item) use ($currency) {
            return $item['currency'] == $currency;
        });
    }
}
