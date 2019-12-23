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

    Route::post('/', 'ChinchillasController@add');

    Route::put('/{id}', 'ChinchillasController@update');

    Route::delete('/{id}', 'ChinchillasController@delete');

    Route::post('/all', 'ChinchillasController@addAll');

    Route::delete('/all', 'ChinchillasController@deleteAll');
});

Route::prefix('purchases')->group(function() {

    Route::get('/', 'PurchasesController@get');

    Route::post('/', 'PurchasesController@add');

    Route::put('/{id}', 'PurchasesController@update');

    Route::delete('/{id}', 'PurchasesController@delete');

    Route::post('/all', 'PurchasesController@addAll');

    Route::delete('/all', 'PurchasesController@deleteAll');
});

Route::prefix('file')->group(function() {

    Route::post('/', 'FileController@uploadFile');
});

Route::get('/admin/020710', function () {
    return view('admin');
});
