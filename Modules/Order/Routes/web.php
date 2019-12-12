<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('order')->group(function() {
    Route::get('/', 'OrderController@index');
    Route::get('/report', 'OrderController@report');
    Route::post('/GetDataItem', 'OrderController@getDataItem');
    Route::post('/store', 'OrderController@store')->name('order.store');
    Route::post('/editHeader', 'OrderController@editHeader');
    Route::post('/editDetail', 'OrderController@editDetail');
    Route::post('/delete', 'OrderController@delete');
    Route::post('/update', 'OrderController@update')->name('order.update');
    Route::post('/payment', 'OrderController@payment')->name('order.payment');
});
