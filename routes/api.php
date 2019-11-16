<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('chinchillas')->group(function() {

    Route::get('/', 'ChinchillasController@get');

    Route::post('/all', 'ChinchillasController@addAll');
});

Route::prefix('purchases')->group(function() {

    Route::get('/', 'PurchasesController@get');

    Route::post('/all', 'PurchasesController@addAll');
});
