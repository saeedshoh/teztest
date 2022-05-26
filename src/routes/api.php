<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" Namespace group. Enjoy building your API!
|
*/

Route::namespace('API')->group(base_path('/routes/api/v0.php'));
