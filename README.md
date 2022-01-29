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

---
## How to customize Flashlight?

### Kill Switch

If you wish to turn Flashlight on/off for a short time, you can do so by editing `enabled` key inside `flashlight.php` config file under `App/config`.
```php
'enabled' => true
```
Note that by default Flashlight **is** enabled. 

---
### HTTP Method Customization

If you wish to customize HTTP methods to log you can do so by editing `excluded_methods` array inside `flashlight.php` config file under `App/config`.

For example:
```php
'excluded_methods' => [
    'PUT',
]
```
By doing this, all `PUT` requests are ignored by Flashlight.

Note that by default all HTTP method **are** logged by Flashlight.

---
### URI Customization

If you wish to customize URIs to log you can do so by editing `excluded_uris` array inside `flashlight.php` config file under `App/config`.

For example:
```php
'excluded_uris' => [
    '/admin/*',
]
```
By doing this, all requests under `/admins` are ignored by Flashlight.

Note that by default all requests **are** logged by Flashlight.

---