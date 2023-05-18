<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
        return view('login');
});

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/','ProductController@index')->name('product');
Route::get('/create','ProductController@create')->name('create');
Route::get('/{keyword}','ProductController@search')->name('search');


Route::post('/store','ProductController@store')->name('store');
Route::get('/show/{id}','ProductController@show')->name('show');
Route::get('/edit/{id}','ProductController@edit')->name('edit');
Route::post('/update','ProductController@update')->name('update');
Route::get('/destroy/{id}', 'ProductController@destroy')->name('destroy');
Route::post('/pay/{id}', 'ProductController@pay')->name('product.pay');

//機能
Route::resource('product', 'ProductController', ['only' => ['index','create','show','edit','store', 'destroy','search','pay']]);

