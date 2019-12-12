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

Route::prefix('food')->group(function() {
    Route::get('/', 'FoodController@index');
    Route::post('/store', 'FoodController@store')->name('food.store');
    Route::post('/update', 'FoodController@update')->name('food.update');
    Route::post('/delete', 'FoodController@delete')->name('food.delete');
});
