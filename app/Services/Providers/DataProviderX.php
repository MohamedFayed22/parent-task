<?php

namespace App\Services\Providers;

use File;
use App\Services\Interfaces\DataProviderInterface;

class DataProviderX implements DataProviderInterface
{
    protected array $statusCode = [
        '1' => 'authorised',
        '2' => 'decline',
        '3' => 'refunded'
    ];

    /**
     * Get data from DataProviderX.
     *
     * @return array The data from DataProviderX.
     */
    public function getDataProvider(): array
    {
        $dataProviderX = File::get(storage_path('DataProviderX.json'));

        $dataX = json_decode($dataProviderX, true);

        return $this->transformData($dataX);
    }

    /**
     * Transform raw data from DataProviderX.
     *
     * @param array $data The raw data from DataProviderX.
     * @return array The transformed data.
     */
    private function transformData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'parentEmail' => $item['parentEmail'],
                'amount' => $item['parentAmount'],
                'currency' => $item['Currency'],
                'status' => $this->statusCode[$item['statusCode']],
                'created_at' => $item['registerationDate'],
                'id' => $item['parentIdentification'],
                'provider' => 'DataProviderX',
            ];
        }, $data);
    }
}
