<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kill switch
    |--------------------------------------------------------------------------
    |
    | This option is used to enable / disable the Flashlight.
    |
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Flashlight Middleware
    |--------------------------------------------------------------------------
    |
    | This class is responsible for everything Flashlight does.
    |
    */
    'middleware_class' => HesamRad\Flashlight\Middleware\FlashlightMiddleware::class,

    /*
    |--------------------------------------------------------------------------
    | Flashlight log file
    |--------------------------------------------------------------------------
    |
    | The address in which all Flashlight logs are stored.
    |
    */
    'path_to_log_file' => storage_path('logs/Flashlight.log'),

    /*
    |--------------------------------------------------------------------------
    | Excluded HTTP Methods
    |--------------------------------------------------------------------------
    |
    | The list of HTTP methods which Flashlight won't log.
    |
    */
    'excluded_methods' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded URIs
    |--------------------------------------------------------------------------
    |
    | The list of URIs which Flashlight won't log.
    |
    */
    'excluded_uris' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Parameters
    |--------------------------------------------------------------------------
    |
    | The list of parameters which Flashlight won't log.
    |
    */
    'excluded_parameters' => [
        'password',
        'password_confirmation'
    ],

    /*
    |--------------------------------------------------------------------------
    | Request Headers
    |--------------------------------------------------------------------------
    |
    | This option indicates if Flashlight can log request headers or not.
    |
    */
    'log_headers' => true,

    /*
    |--------------------------------------------------------------------------
    | Request Body
    |--------------------------------------------------------------------------
    |
    | This option indicates if Flashlight can log request body or not.
    |
    */
    'log_body' => true,
];
