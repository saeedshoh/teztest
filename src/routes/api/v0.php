<?php

use Illuminate\Support\Facades\Route;

$v0RouteGroup = ["prefix" => "v0", "namespace" => "v0"];

Route::group($v0RouteGroup, function () {
    Route::middleware('auth:token', 'throttle:60,1')->group(function () {

        Route::prefix('/main')->namespace('Main')->group(function () {
            Route::get('/', 'MainController@index');
            Route::post('/agree_regulation', 'MainController@agreeRegulation');
        });

        Route::prefix('/products')->namespace('Products')->group(function () {
            Route::get('/', 'ProductController@index');
            Route::get('/{id}', 'ProductController@getById')->where(['id' => '[0-9]+']);
            Route::get('/general_filters', 'ProductController@getGeneralFilters');
            Route::get('/shop_filters/{shopId}', 'ProductController@getShopFilters');
            Route::prefix('/categories')->group(function () {
                Route::get('/', 'CategoryController@getAll');
                Route::get('/shop/{shop_id}', 'CategoryController@getShopCategories')->where(['shop_id' => '[0-9]+']);;
            });

            Route::prefix('/wishlists')->group(function(){
                Route::get('/', 'WishListController@getBySubscriberId');
                Route::post('/', 'WishListController@store');
                Route::delete('/', 'WishListController@destroy');
            });
        });

        Route::prefix('/shops')->namespace('Shops')->group(function (){
            Route::get('/', 'ShopController@index');
            Route::get('/{id}', 'ShopController@getById')->where(['id' => '[0-9]+']);

            Route::prefix('/subscriptions')->group(function (){
                Route::post('/','ShopController@subscribe');
                Route::delete('/','ShopController@unsubscribe');
            });
        });

        Route::prefix('/cart')->namespace('Carts')->group(function (){
            Route::get('/', 'CartController@getBySubscriberId');
            Route::post('/', 'CartController@add');
            Route::delete('/', 'CartController@delete');
            Route::put('/remove_quantity', 'CartController@removeQuantity');
        });

        Route::prefix('/orders')->namespace('Orders')->group(function (){
            Route::post('/', 'OrderController@createOrderByTezsum');
            Route::post('/by_credit_card', 'OrderController@createOrderByCreditCard');
            Route::get('/filters', 'OrderController@getOrderFilters');
            Route::get('/client_orders', 'OrderController@getOrdersByClientId');
            Route::get('/client_orders/{id}', 'OrderController@getOrderByClientId');
            Route::post('/confirm', 'OrderController@confirmOrder');
            Route::post('/return_order', 'OrderController@returnOrder');
        });

        Route::prefix('/advertising_banners')->namespace('AdvertisingBanners')->group(function (){
            Route::get('/','AdvertisingBannerController@index');
        });

        Route::prefix('/common')->namespace('Common')->group(function (){
           Route::post('/complaints', 'ComplaintController@store');
        });

        Route::prefix('/cards')->namespace('Cards')->group(function (){
            Route::get('/', 'CardController@getCardsByPhoneNumber');
            Route::post('/', 'CardController@addCard');
            Route::delete('/', 'CardController@removeCard');
        });

        Route::prefix('/integrations')->namespace('Integrations')->group(function (){
            Route::prefix('/tezsum')->group(function (){
                Route::get('/my_balance', 'TezsumController@myBalance');
            });
        });
    });

    Route::middleware('auth:sanctum')->namespace('WebServices')->prefix('/web_services')->group(function (){
        Route::post('/clients/destroy_token', 'MyTcellController@destroyClientToken');
    });
});
