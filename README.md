![Flashlight Cover](https://raw.githubusercontent.com/hesamzakerirad/laravel-flashlight/master/media/cover.jpg "Flashlight Cover")

# Laravel Flashlight
Laravel-Flashlight is a minimal package to log incoming requests to your application; it is highly customizable and easy to install.

## How to install?
Take these steps to install Flashlight.

### Step #1
Install the package from Composer.

```php
composer require hesamrad/laravel-flashlight
```

### Step #2
Publish congifuration file.

```php
php artisan vendor:publish --provider="HesamRad\Flashlight\FlashlightServiceProvider" --tag="flashlight-config"
```

### Step #3
Publish migration file. (Only if you want to store logs inside your database.)

```php
php artisan vendor:publish --provider="HesamRad\Flashlight\FlashlightServiceProvider" --tag="flashlight-migration"
```

### Step #4
Apply middleware on routes.

```php
Route::middleware('flashlight')->group(function () {
    Route::get('/', [SomeController::class, 'index']);
});
```

And you're done!

Now every request that goes through Flashlight will be logged to be monitored later.

Note that all Flashlight logs are stored in `flashlight.log` file under `storage/logs`.

---
## How to customize Flashlight?

### Kill Switch

If you wish to turn Flashlight on/off for a short time, you can do so by editing `enabled` key inside `flashlight.php` config file under `App/config`.
```php
'enabled' => true
```
Note that by default Flashlight **is** enabled. 

### Database Option
If you wish to store logs inside your database, you can do so by editing `log_to_database` key inside `flashlight.php` config file under `App/config`.
```php
'log_to_database' => true
```
Note that by default Flashlight **stores** logs inside the database. 

### File Option
If you wish to store logs inside a local file, you can do so by editing `log_to_file` key inside `flashlight.php` config file under `App/config`.
```php
'log_to_file' => true
```
Note that by default Flashlight **stores** logs in a local file called `flashlight.log` under `App/storage/logs`. 

---
### HTTP Method Customization

If you wish to customize HTTP methods to log, you can do so by editing `excluded_methods` array inside `flashlight.php` config file under `App/config`.

For example:
```php
'excluded_methods' => [
    'put',
]
```
By doing this, all `PUT` requests are ignored by Flashlight.

Note that by default all HTTP method **are** logged by Flashlight.

---
### Log Request Headers

If you wish to log request headers, you can do so by editing `log_headers` key inside `flashlight.php` config file under `App/config`.

```php
'log_headers' => true
```
Note that by default request headers **are** logged by Flashlight.

---

### Log Request Body

If you wish to log request body, you can do so by editing `log_body` key inside `flashlight.php` config file under `App/config`.

```php
'log_body' => true
```
Note that by default request body **is** logged by Flashlight.

---

### Request Parameters Customization

If you wish to customize request parameters to log, you can do so by editing `excluded_parameters` array inside `flashlight.php` config file under `App/config`.

For example:
```php
'excluded_parameters' => [
    'password',
    'password_confirmation',
]
```
By doing this, all specified parameters are ignored by Flashlight.

Note that by default `password` and `password_confirmation` parameters **are** ignored by Flashlight.

---

### URI Customization

If you wish to customize URIs to log, you can do so by editing `excluded_uris` array inside `flashlight.php` config file under `App/config`.

For example:
```php
'excluded_uris' => [
    'admins*',
]
```
By doing this, all requests under `/admins` are ignored by Flashlight.

Note that by default all requests **are** logged by Flashlight.

---
