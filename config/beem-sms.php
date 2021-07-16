<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Base Url
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    |
    */
    "base_url" => env("BEEM_SMS_BASE_URL", "https://apisms.beem.africa/v1/"),
    /*
    |--------------------------------------------------------------------------
    | Default Source Address
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    |
    */
    "source_address" => env("BEEM_SMS_SOURCE_ADDRESS", "INFO"),

    /*
    |--------------------------------------------------------------------------
    | Api key
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */
    "api_key" => env("BEEM_SMS_API_KEY"),

    /*
    |--------------------------------------------------------------------------
    | Secret key
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    */
    "secret_key" => env("BEEM_SMS_SECRET_KEY")
];
