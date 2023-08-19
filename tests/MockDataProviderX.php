<?php


namespace Tests;

use App\Services\Providers\DataProviderX;

class MockDataProviderX extends DataProviderX
{
    public function getDataProvider(): array
    {
        // Simulate DataProviderX response data for testing
        return [
            [
                'parentEmail' => 'user1@example.com',
                'parentAmount' => 100,
                'Currency' => 'USD',
                'statusCode' => '1',
                'registerationDate' => '2023-08-01',
                'parentIdentification' => '123456',
            ],
            // Add more simulated data entries here
        ];
    }

    public function shouldReceive(string $string)
    {
    }
}
