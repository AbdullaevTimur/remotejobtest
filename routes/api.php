<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function () {
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::group(['prefix' => 'search'], function () {
        Route::get('/', 'EstateController@index');
    });
});
