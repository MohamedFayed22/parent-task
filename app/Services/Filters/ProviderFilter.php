<?php

namespace App\Services\Filters;


use App\Services\Interfaces\FilterInterface;

class ProviderFilter implements FilterInterface
{
    /**
     * Filter data based on provider.
     *
     * @param array $data The data to be filtered.
     * @param $request.
     * @return array The filtered data.
     */
    public function filter($data, $request): array
    {
        $provider = $request->input('provider');

        if ($provider === null) {
            return $data; // No filtering needed, return original data
        }

        return $this->applyProviderFilter($data, $provider);
    }

    /**
     * Apply provider filter to the data.
     *
     * @param array $data The data to be filtered.
     * @param string $provider The provider to filter by.
     * @return array The filtered data.
     */
    private function applyProviderFilter(array $data, string $provider): array
    {
        return array_filter($data, function ($item) use ($provider) {
            return $item['provider'] == $provider;
        });
    }
}
