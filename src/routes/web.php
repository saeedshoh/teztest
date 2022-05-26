<?php
use Illuminate\Support\Facades\Route;


// Route::get('/', 'HomeController@index');


// Route::namespace('Admin')->middleware('auth')->group(function (){
//     Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

//     Route::namespace('Main')->group(function (){
//         Route::get('/', 'MainController@index');
//         Route::get('/complaints', 'ComplaintController@index');
//         Route::get('/complaints/{show}', 'ComplaintController@show');
//     });

//     /**
//      * Продукты
//      */
//     Route::prefix('products')->namespace('Products')->group(function (){

//         Route::get('/', 'ProductController@index')->name('products.index');
//         Route::get('/table', 'ProductController@getProductsTable');
//         Route::get('/create', 'ProductController@create')->name('products.create');
//         Route::post('/store', 'ProductController@store')->name('products.store');
//         Route::put('/{product}', 'ProductController@update')->name('products.update');
//         Route::get('/{product}/show', 'ProductController@show')->name('products.show')->where(['product' => '[0-9]+']);
//         Route::get('/{product}/edit', 'ProductController@edit')->name('products.edit')->where(['product' => '[0-9]+']);
//         Route::delete('/{product}/destroy', 'ProductController@destroy')->name('products.destroy')->where(['product' => '[0-9]+']);

//         Route::get('/shop', 'ProductController@getByShopId');

//         Route::post('/images/upload','ProductController@uploadProductMedia');
//         Route::delete('/images/delete/{productMedia}','ProductController@deleteProductMedia');
//         Route::put('/images/is_default/{productMedia}','ProductController@isDefaultProductMedia');

//         Route::resource('categories', 'CategoryController');
//         Route::get('/categories/audit/{category}', 'CategoryController@audit')->name('categories.audit');
//         Route::resource('brands', 'BrandController');

//         Route::prefix('statuses')->group(function (){
//             Route::put('pending/{product}', 'ProductStatusController@changeToPending');
//             Route::put('active/{product}', 'ProductStatusController@changeToActive');
//             Route::put('denied/{product}', 'ProductStatusController@changeToDenied');
//         });

//         /**
//          * Опции
//          */
//         Route::resource('option_types', 'ProductOptionTypeController');
//         Route::resource('option_values', 'ProductOptionValueController');
//         Route::get('option_values/{optionTypeId}/by_option_type', 'ProductOptionValueController@optionValueByOptionType');
//         Route::prefix('options')->group(function (){
//             Route::post('/', 'ProductOptionController@store');
//             Route::put('/', 'ProductOptionController@update');
//             Route::delete('/{option}', 'ProductOptionController@destroy')->name('options.destroy');
//         });
//     });



//     /**
//      * Магазины
//      */
//     Route::prefix('shops')->namespace('Shops')->group(function (){
//         Route::resource('shop_categories', 'ShopCategoryController');
//         Route::post('/{shop}/tezsum_site_id', 'ShopController@addTezsumSiteId')->where(['shop' => '[0-9]+']);
//         Route::post('/transfer_to_card', 'ShopController@transferToCard');
//         Route::post('/transfer_to_bank_account', 'ShopController@transferToBankAccount');

//         Route::get('/my_shop','ShopController@myShop');
//         Route::get('/transfers', 'ShopController@getShopTransfers');
//         Route::get('/','ShopController@index')->name('shops.index');

//         Route::get('/create','ShopController@create')->name('shops.create');
//         Route::post('/store','ShopController@store')->name('shops.store');
//         Route::get('/{shop}', 'ShopController@show')->where(['shop' => '[0-9]+'])->name('shops.show');
//         Route::get('/{shop}/edit', 'ShopController@edit')->where(['shop' => '[0-9]+'])->name('shops.edit');
//         Route::put('/{shop}', 'ShopController@update')->where(['shop' => '[0-9]+']);
//         Route::put('/change_status/{shop}', 'ShopController@blockHideActive')->where(['shop' => '[0-9]+']);
//         Route::delete('/{shop}', 'ShopController@destroy')->name('shops.destroy');
//         Route::post('/upload_files', 'ShopController@uploadFiles');
//         Route::delete('/delete_file/{shop_media}', 'ShopController@deleteFile')->where(['shop_media' => '[0-9]+']);

//         Route::get('/audit/{shop}', 'ShopController@audit')->name('shops.audit');
//     });

//     /**
//      * Заказы
//      */
//     Route::namespace('Orders')->group(function (){

//         Route::prefix('orders')->group(function (){
//             Route::get('/','OrderController@index');
//             Route::get('/{id}','OrderController@show');

//             Route::prefix('statuses')->group(function (){
//                 Route::put('sent/{order}', 'OrderController@changeStatusToSent');
//                 Route::put('performed/{order}', 'OrderController@changeStatusToPerformed');
//                 Route::put('denied/{order}', 'OrderController@changeStatusToDenied');
//                 Route::post('change_order_status', 'OrderController@changeStatusById');
//             });
//         });

//         Route::resource('delivery_agencies', 'DeliveryAgencyController');
//     });

//     Route::namespace('Audits')->prefix('audits')->group(function (){
//         Route::get('/', 'AuditController@index');
//     });



//     Route::resource('users', 'UserController');
//     Route::get('/users/audit/{user}', 'UserController@audit')->name('users.audit');
//     Route::resource('roles', 'RoleController');
// });


