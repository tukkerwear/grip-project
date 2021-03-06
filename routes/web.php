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
Auth::loginUsingId(1);

$router->get('/')->uses('PageController@index')->name('pages.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
