<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Shared\TenantSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ($_SERVER['argv'][1] != 'tenants:migrate') {
            $this->call([
                TenantSeeder::class,
            ]);
        }
        $this->call([
            UserSeeder::class,
        ]);
    }
}
