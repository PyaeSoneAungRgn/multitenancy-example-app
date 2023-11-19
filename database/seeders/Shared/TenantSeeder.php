<?php

namespace Database\Seeders\Shared;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'name' => 'Tenant 1',
            'domain' => 'tenant1.multitenancy.test',
            'database' => 'tenant1',
        ]);

        Tenant::create([
            'name' => 'Tenant 2',
            'domain' => 'tenant2.multitenancy.test',
            'database' => 'tenant2',
        ]);
    }
}
