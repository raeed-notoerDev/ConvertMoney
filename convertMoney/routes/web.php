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
//Route::get('/{path?}', 'HomeController@index')->where('path', '[\/\w\.-]*');
Route::get('/{vue_capture}','HomeController@index')->where('vue_capture','[\/\w\.-]*');
//Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/register', 'ErrorController@show');
//Route::get('/transaction', 'ErrorController@showTransaction');
Route::post('/user/register', 'ErrorController@register')->name('register');
//Route::post('/create-transaction', 'ErrorController@create_transaction');
