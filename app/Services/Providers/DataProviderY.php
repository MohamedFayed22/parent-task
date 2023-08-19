<?php

namespace App\Services\Providers;

use File;
use App\Services\Interfaces\DataProviderInterface;

class DataProviderY implements DataProviderInterface
{
    protected array $statusCode = [
        '100' => 'authorised',
        '200' => 'decline',
        '300' => 'refunded'
    ];

    /**
     * Get data from DataProviderY.
     *
     * @return array The data from DataProviderY.
     */
    public function getDataProvider(): array
    {
        $dataProviderY = File::get(storage_path('DataProviderY.json'));
        $dataY = json_decode($dataProviderY, true);

        return $this->transformData($dataY);
    }

    /**
     * Transform raw data from DataProviderY.
     *
     * @param array $data The raw data from DataProviderY.
     * @return array The transformed data.
     */
    private function transformData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'parentEmail' => $item['email'],
                'amount' => $item['balance'],
                'currency' => $item['currency'],
                'status' => $this->statusCode[$item['status']],
                'created_at' => $item['created_at'],
                'id' => $item['id'],
                'provider' => 'DataProviderY',
            ];
        }, $data);
    }
}
