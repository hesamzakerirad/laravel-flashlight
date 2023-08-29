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
    | Default Driver class
    |--------------------------------------------------------------------------
    |
    | This option uses the specified driver to log request.
    |
    */
    'driver' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Driver classes
    |--------------------------------------------------------------------------
    |
    | This option uses a driver class to store logs.
    | Currently there are two drivers available: file and database.
    |
    | file driver     =>  \HesamRad\Flashlight\Drivers\File::class
    | database driver =>  \HesamRad\Flashlight\Drivers\Database::class
    |
    */
    'drivers' => [
        'file' => [
            // The file class to store logs.
            'concrete' => \HesamRad\Flashlight\Drivers\File::class,

            // File path in which logs are stored.
            'path' => storage_path('logs/flashlight.log'),
        ], 

        'database' => [
            // The file class to store logs.
            'concrete' => \HesamRad\Flashlight\Drivers\Database::class,

            // Database table in which logs are stored.
            'path' => 'flashlight_logs',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Flashlight Middleware
    |--------------------------------------------------------------------------
    |
    | This class the layer every request passes though.
    |
    */
    'middleware_class' => \HesamRad\Flashlight\Middleware\FlashlightMiddleware::class,

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

    /*
    |--------------------------------------------------------------------------
    | Prune Period
    |--------------------------------------------------------------------------
    |
    | This option indicates the number of days within which to keep logs.
    | 
    | The default number is 30; which means flashlight can delete log 
    | records that are older than 30 days.
    |
    */
    'prune_period' => 30,
];
