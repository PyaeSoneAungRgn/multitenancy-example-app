<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;

class TenancyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRequest();
        $this->configureQueue();
    }

    private function configureRequest()
    {
        if (! $this->app->runningInConsole()) {
            $host = $this->app->request->getHost();
            Tenant::where('domain', $host)->firstOrFail()
                ->configure()
                ->use();
        }
    }

    private function configureQueue()
    {
        $this->app->queue->createPayloadUsing(function () {
            return $this->app->tenant
                ? ['tenant_id' => $this->app->tenant->id]
                : [];
        });

        $this->app->events->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['tenant_id'])) {
                Tenant::find($event->job->payload()['tenant_id'])->configure()->use();
            }
        });
    }
}
