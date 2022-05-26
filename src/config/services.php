<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mytcell' => [
        'api_url' => env('MY_TCELL_URI_API')
    ],

    'tezsum' => [
        'api_user_url' => env('TEZSUM_URI_USER_API'),
        'api_merchant_url' => env('TEZSUM_URI_MERCHANT_API'),
        'secure_key' => env('TEZSUM_X_API_SECURE_KEY'),
        'hash_hmac_key' => env('TEZSUM_HASH_HMAC_KEY'),
        'merchant_sid' => env('TEZSUM_MERCHANT_SITE_ID')
    ],

    'sms' => [
        'url' => env('SMS_CENTER_URL'),
        'login' => env('SMS_CENTER_LOGIN'),
        'pass' => env('SMS_CENTER_PASS')
    ]

];
