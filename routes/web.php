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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/product/{slug}', 'ProductController@index')->name('product');

Route::get('/currency/{currency}', 'CurrencyController@index')->name('currency');

Route::get('/shoppingcart/buy', 'ShoppingCartController@buy')->name('shoppingcart.buy');

Route::resource('shoppingcart', 'ShoppingCartController');
