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
    | Database Option
    |--------------------------------------------------------------------------
    |
    | This option is used to enable /disable writing to database.
    |
    */
    'log_to_database' => true,

    /*
    |--------------------------------------------------------------------------
    | File Option
    |--------------------------------------------------------------------------
    |
    | This option is used to enable /disable writing to file.
    |
    */
    'log_to_file' => true,

    /*
    |--------------------------------------------------------------------------
    | Database Table
    |--------------------------------------------------------------------------
    |
    | This is the name of the table Flashlight uses to store logs inside.
    |
    */
    'logs_table_name' => 'flashlight_logs',

    /*
    |--------------------------------------------------------------------------
    | Flashlight Class
    |--------------------------------------------------------------------------
    |
    | This is the main class that is used through out the package.
    |
    */
    'flashlight_class' => HesamRad\Flashlight\Flashlight::class,

    /*
    |--------------------------------------------------------------------------
    | Flashlight Middleware
    |--------------------------------------------------------------------------
    |
    | This class the layer every request passes though.
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
    'path_to_log_file' => storage_path('logs/flashlight.log'),

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
