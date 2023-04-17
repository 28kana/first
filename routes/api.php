<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;


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

// Route::get('/','ProductController@index')->name('product');
// Route::get('/show/{id}','ProductController@show')->name('show');
// Route::post('/pay', 'ProductController@pay')->name('pay');



});
