<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kill switch
    |--------------------------------------------------------------------------
    |
    | This option is used to enable or disable to logger.
    |
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Flashlight Middleware
    |--------------------------------------------------------------------------
    |
    | This class is responsible for everything flashlight does.
    |
    */
    'middleware_class' => HesamRad\Flashlight\Middleware\FlashlightMiddleware::class,

    /*
    |--------------------------------------------------------------------------
    | Flashlight log file
    |--------------------------------------------------------------------------
    |
    | The address in which all flashlight logs are stored.
    |
    */
    'path_to_log_file' => storage_path('logs/flashlight.log'),

    /*
    |--------------------------------------------------------------------------
    | Excluded HTTP Methods
    |--------------------------------------------------------------------------
    |
    | The list of HTTP methods which flashlight won't log.
    |
    */
    'excluded_methods' => [],

    /*
    |--------------------------------------------------------------------------
    | Excluded URIs
    |--------------------------------------------------------------------------
    |
    | The list of URIs which flashlight won't log.
    |
    */
    'excluded_uris' => [],
];
