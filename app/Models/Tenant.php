<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Tenant extends Model
{
    use HasFactory;

    protected $connection = 'shared';

    protected $fillable = [
        'name',
        'domain',
        'database',
    ];

    public function configure(): static
    {
        config([
            'database.connections.tenant.database' => $this->database,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

        config([
            'cache.prefix' => $this->database.'_cache_',
        ]);

        return $this;
    }

    public function use(): static
    {
        app()->forgetInstance('tenant');
        app()->instance('tenant', $this);

        return $this;
    }
}
