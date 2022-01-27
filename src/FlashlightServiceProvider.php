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
        Request::macro('flashlight', function () {
            $flashlight = new Flashlight(config('flashlight'));

            $flashlight->call();
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
