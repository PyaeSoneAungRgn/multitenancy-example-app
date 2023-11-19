<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Tenant;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.connections.shared' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],

            'database.connections.tenant' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
        ]);

        $this->artisan('migrate --database=shared --path=database/migrations/shared');
        $this->artisan('migrate --database=tenant');
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_users_response(): void
    {
        $tenant = Tenant::factory()->create();

        $tenant->use();

        User::factory()->count(10)->create();

        $response = $this->getJson('/api/users');
        $response->assertJsonCount(10, 'data');
    }
}
