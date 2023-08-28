<?php

namespace HesamRad\Flashlight;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class FlashlightServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Publish the config file to control Flashlight.
        $this->publishes([
            __DIR__ . '/../config/flashlight.php' => config_path('flashlight.php')
        ], 'flashlight-config');

        // Publish the migration file to store Flashlight logs
        if (! class_exists('CreateFlashlightLogsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_flashlight_logs_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_flashlight_logs_table.php'),
            ], 'flashlight-migration');
        }

        // Registering Flashlight middleware so you don't have to :)
        app('router')->aliasMiddleware('flashlight', config('flashlight.middleware_class'));

        // Binding Flashlight to the application.
        $this->app->singleton(\HesamRad\Flashlight\Flashlight::class, function () {
            $driver = config('flashlight.driver');
            $concrete = config('flashlight.drivers.' . $driver . '.concrete');
            $path = config('flashlight.drivers.' . $driver . '.path');

            return new \HesamRad\Flashlight\Flashlight(
                config('flashlight'), 
                new $concrete($path) 
            );
        });

        // Registering commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \HesamRad\Flashlight\Commands\Prune::class,
            ]);
        }
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering a custom macro to Request class.
        Request::macro('call', function () {
            return app(\HesamRad\Flashlight\Flashlight::class)->run($this);
        });
    }
}
