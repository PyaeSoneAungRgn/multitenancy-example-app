<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class TenantsMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {tenant?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tenants migrate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant');
        Tenant::when($tenantId, function ($query, $tenantId) {
            $query->where('id', $tenantId);
        })->each(function ($tenant) {
            $this->migrate($tenant);
        });
    }

    protected function migrate(Tenant $tenant)
    {
        $tenant->configure()->use();
        info("Migrating tenant {$tenant->id} ({$tenant->name})");

        $options = ['--force' => true];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call(
            $this->option('fresh') ? 'migrate:fresh' : 'migrate',
            $options
        );
    }
}
