![Flashlight Cover](https://raw.githubusercontent.com/hesamzakerirad/laravel-flashlight/master/media/cover.jpg "Flashlight Cover")
# Laravel Flashlight
Laravel-Flashlight is a minimal package to log incoming requests to your application; it is highly customizable and easy to install.

## How to install?
Take these steps to install Flashlight.

### Step #1
Install the package from Composer.

```
composer require hesamrad/laravel-flashlight
```

### Step #2
Publish congifuration file.

```
php artisan vendor:publish --provider="HesamRad\Flashlight\FlashlightServiceProvider" --tag="flashlight-config"
```

### Step #3
Apply middleware on routes.

```php
Route::middleware('flashlight')->group(function () {
    Route::get('/', [SomeController::class, 'index']);
});
```

And you're done!

Now every request that goes through Flashlight will be logged to be monitored later.

Note that all Flashlight logs are stored in `flashlight.log` file under `storage/logs/flashlight.log`.