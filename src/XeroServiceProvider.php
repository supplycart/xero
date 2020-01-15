<?php

namespace Supplycart\Xero;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class XeroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        XeroManager::routes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/xero.php', 'xero');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
