<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HotelController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['namespace' => 'Api'], function () {
    Route::get('/items', 'HotelController@index');
    Route::get('/items/{id}', 'HotelController@show');
    Route::post('/items', 'HotelController@create');
    Route::put('/items/{id}', 'HotelController@update');
    Route::delete('/items/{id}', 'HotelController@destroy');

    Route::post('/bookings', 'BookingController@create');

});
