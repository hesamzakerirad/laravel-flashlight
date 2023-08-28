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
        $this->app->singleton(config('flashlight.flashlight_class'), function () {
            return new (config('flashlight.flashlight_class'))(config('flashlight'), config('flashlight.driver'));
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
            return app(config('flashlight.flashlight_class'))->run($this);
        });
    }
}
