<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'bitdif.com'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Generate Thumbnails
    |--------------------------------------------------------------------------
    |
    | Here you may choose to generate thumbnails for images uploaded to the app or not
    | and use the full image instead. I do not recommend this for production. However you do you.
    |
    */

    'gen_thumbnails' => env('APP_GEN_THUMBNAILS', true),

    /*
    |--------------------------------------------------------------------------
    | Allow Registration
    |--------------------------------------------------------------------------
    |
    | Choose whether to allow users to register on the app or not.
    |
    */

    'allow_registration' => env('APP_ALLOW_REGISTRATION', false),

    /*
    |--------------------------------------------------------------------------
    | Allow Upload Via Paste
    |--------------------------------------------------------------------------
    |
    | This enables the ability to upload images via pasting them or a web address
    | into the app.
    |
    */

    'allow_upload_via_paste' => env('APP_ALLOW_UPLOAD_VIA_PASTE', true),

    /*
    |--------------------------------------------------------------------------
    | Enable API
    |--------------------------------------------------------------------------
    |
    | This enables or disabled the ability to use the API for the app.
    |
    */

    'enable_api' => env('APP_ENABLE_API', true),

    /*
    |--------------------------------------------------------------------------
    | Enable Image Caching
    |--------------------------------------------------------------------------
    |
    | If you want to cache images or not. This is useful for speeding up the app.
    | However it does require a cache driver to be set up.
    |
    */

    'enable_image_caching' => env('APP_ENABLE_IMAGE_CACHING', true),

];
