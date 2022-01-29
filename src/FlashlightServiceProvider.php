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
            __DIR__.'/../config/flashlight.php' => config_path('flashlight.php')
        ], 'flashlight-config');

        //register middleware
        app('router')->aliasMiddleware('flashlight', config('flashlight.middleware_class'));
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('flashlight', function () {
            $flashlight = new Flashlight(config('flashlight'));

            $flashlight->call($this);
        });
    }
}
