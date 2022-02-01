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
        //publish config file
        $this->publishes([
            __DIR__ . '/../config/flashlight.php' => config_path('flashlight.php')
        ], 'flashlight-config');

        //register middleware
        app('router')->aliasMiddleware('flashlight', config('flashlight.middleware_class'));

        //binding Flashlight as a singleton
        $this->app->singleton(config('flashlight.flashlight_class'), function () {
            return new (config('flashlight.flashlight_class'))(config('flashlight'));
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //registering a custom macro
        Request::macro('call', function () {
            return app(config('flashlight.flashlight_class'))->run($this);
        });
    }
}
