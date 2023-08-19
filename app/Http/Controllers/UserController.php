<?php

namespace App\Http\Controllers;

use App\Services\Filters\BalanceFilter;
use App\Services\Filters\CurrencyFilter;
use App\Services\Filters\DataFilterManager;
use App\Services\Filters\ProviderFilter;
use App\Services\Filters\StatusFilter;
use App\Services\Providers\DataProviderX;
use App\Services\Providers\DataProviderY;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get users from data sources, filter them, and return as JSON response.
     *
     * @param Request $request The incoming HTTP request.
     * @return JsonResponse The JSON response containing filtered user data.
     */
    public function getUsers(Request $request)
    {
        $dataSources = [
            new DataProviderX(),
            new DataProviderY(),
        ];

        $filteredData = $this->fetchAndFilterData($dataSources, $request);
        $users = $this->transformData($filteredData);

        return response()->json($users);
    }

    /**
     * Fetch data from various sources and apply filters.
     *
     * @param array $dataSources The array of data source instances.
     * @param Request $request The incoming HTTP request.
     * @return array The filtered data.
     */
    private function fetchAndFilterData(array $dataSources, Request $request): array
    {
        $data = [];

        foreach ($dataSources as $dataSource) {
            $data = array_merge($data, $dataSource->getDataProvider());
        }

        $filterContext = new DataFilterManager();
        $filterContext->addFilter(new ProviderFilter());
        $filterContext->addFilter(new StatusFilter());
        $filterContext->addFilter(new BalanceFilter());
        $filterContext->addFilter(new CurrencyFilter());

        return $filterContext->filter($data, $request);
    }

    /**
     * Transform filtered data into desired format.
     *
     * @param array $data The filtered data.
     * @return array The transformed data.
     */
    private function transformData(array $data): array
    {
        $transformedData = [];

        foreach ($data as $item) {
            $transformedData[] = [
                'parentEmail' => $item['parentEmail'],
                'amount' => $item['amount'],
                'currency' => $item['currency'],
                'status' => $item['status'],
                'created_at' => $item['created_at'],
                'id' => $item['id'],
                'provider' => $item['provider'],
            ];
        }

        return $transformedData;
    }
}
