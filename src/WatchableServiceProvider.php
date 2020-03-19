<?php

namespace Telkins\Watchable;

use Illuminate\Support\ServiceProvider;

class WatchableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/../config/config.php' => config_path('watchable.php'),
            // ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            if (! class_exists('CreateWatchablesTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_watchables_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_watchables_table.php'),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        // 
    }
}