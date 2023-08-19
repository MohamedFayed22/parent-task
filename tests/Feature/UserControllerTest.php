<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Services\Providers\DataProviderX;
use App\Services\Providers\DataProviderY;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\MockDataProviderX;
use Tests\MockDataProviderY;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testGetUsersReturnsFilteredData()
    {
        // Create mock data providers
        $dataProviderX = new MockDataProviderX();
        $dataProviderY = new MockDataProviderY();

        // Mock the data providers' responses
        $dataProviderX->shouldReceive('getDataProvider')->andReturn([
            // Mocked DataProviderX data here
        ]);
        $dataProviderY->shouldReceive('getDataProvider')->andReturn([
            // Mocked DataProviderY data here
        ]);

        // Replace the actual data providers with the mocked ones
        $this->app->instance(DataProviderX::class, $dataProviderX);
        $this->app->instance(DataProviderY::class, $dataProviderY);

        // Create a fake HTTP request with filter parameters
        $request = $this->get('/users', [
            'provider' => 'DataProviderX',
            // Other filter parameters here
        ]);

        // Call the controller action
        $response = $this->getUsers($request);

        // Assert response structure and content
        $response->assertStatus(200);
        $response->assertJsonCount(1); // Adjust count based on your test data

        // Add more assertions as needed
    }

    public function testGetUsersReturnsAllDataWhenNoFilters()
    {
        // Create mock data providers
        $dataProviderX = new MockDataProviderX();
        $dataProviderY = new MockDataProviderY();

        // Mock the data providers' responses
        $dataProviderX->shouldReceive('getDataProvider')->andReturn([
            // Mocked DataProviderX data here
        ]);
        $dataProviderY->shouldReceive('getDataProvider')->andReturn([
            // Mocked DataProviderY data here
        ]);

        // Replace the actual data providers with the mocked ones
        $this->app->instance(DataProviderX::class, $dataProviderX);
        $this->app->instance(DataProviderY::class, $dataProviderY);

        // Create a fake HTTP request without any filter parameters
        $request = $this->get('/users');

        // Call the controller action
        $response = $this->getUsers($request);

        // Assert response structure and content
        $response->assertStatus(200);
        $response->assertJsonCount(2); // Adjust count based on your test data

        // Add more assertions as needed
    }

    private function getUsers($request)
    {
        $controller = new UserController();
        return $controller->getUsers($request);
    }
}
