<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Settings Driver
    |--------------------------------------------------------------------------
    |
    | Settings driver used to store persistent settings.
    |
    | Supported: "database"
    |
    */

    'default' => env('SETTINGS_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable caching
    |--------------------------------------------------------------------------
    |
    | If it is enabled all values gets cached after accessing it.
    |
    */
    'cache' => env('SETTINGS_CACHE', true),

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable value encryption
    |--------------------------------------------------------------------------
    |
    | If it is enabled all values gets encrypted and decrypted.
    |
    */
    'encryption' => env('SETTINGS_ENCRYPTION', false),

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable events
    |--------------------------------------------------------------------------
    |
    | If it is enabled various settings related events will be fired.
    |
    */
    'events' => env('SETTINGS_EVENTS', true),

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable array filter null value
    |--------------------------------------------------------------------------
    |
    | If turned on, the array filters null values.
    |
    */
    'array_filter_null_value' => false,

    /*
    |--------------------------------------------------------------------------
    | Repositories Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the driver information for each repository that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with this package. You are free to add more.
    |
    */

    'repositories' => [

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION', 'mysql'),
            'table' => 'settings',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Key generator class
    |--------------------------------------------------------------------------
    |
    | Key generator is used to generate keys based on setting key and context.
    |
    */
    'key_generator' => \Hongyukeji\LaravelSettings\Settings\KeyGenerator::class,

    /*
    |--------------------------------------------------------------------------
    | Context serializer class
    |--------------------------------------------------------------------------
    |
    | Context serializer serializes context.
    | It is used with "Hongyukeji\LaravelSettings\KeyGenerators\KeyGenerator" class.
    |
    */
    'context_serializer' => \Hongyukeji\LaravelSettings\Settings\ContextSerializer::class,

    /*
    |--------------------------------------------------------------------------
    | Value serializer class
    |--------------------------------------------------------------------------
    |
    | Value serializer serializes / unserializes given value.
    |
    */
    'value_serializer' => \Hongyukeji\LaravelSettings\Settings\ValueSerializer::class,

    /*
    |--------------------------------------------------------------------------
    | Override application config values
    |--------------------------------------------------------------------------
    |
    | If defined, settings package will override these config values from persistent
    | settings repository.
    |
    | Sample:
    |   "app.fallback_locale",
    |   "app.locale" => "settings.locale",
    |
    */

    'override' => [],

    'override_all_config' => false,

];
