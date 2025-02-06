<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | The allowed origins that can access the application. In this case,
    | we will allow React running on localhost.
    |
    */

    'supports_credentials' => true,

    'allowed_origins' => ['http://192.168.1.22:5173'],  // React app URL


    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Origin',
        'Accept',
        'X-Auth-Token',
    ],

    'allowed_methods' => [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS',
    ],

    'exposed_headers' => [],
    'max_age' => 0,
];
