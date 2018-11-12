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


$router->middleware(['auth'])->group(function () use ($router) {
    $router->patch('series/{serie}/ratings')->uses('Api\SerieRatingController@update')->name('series.ratings.patch');
    $router->delete('series/{serie}/ratings')->uses('Api\SerieRatingController@destroy')->name('series.ratings.destroy');
});
