<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'uri' => [
        'category_icon' => env('CATEGORY_ICON_URI'),
        'shop_media' => env('SHOP_MEDIA_URL'),
        'product_media' => env('PRODUCT_MEDIA_URL')
    ]

];
