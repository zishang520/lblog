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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//前台API
Route::group(['namespace' => 'Api\Home'], function () {
    Route::get('/', 'IndexController@index');
});

//后台API
Route::group(['namespace' => 'Api\Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'IndexController@index');
});
