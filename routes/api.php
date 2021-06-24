<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Auth\AuthController;

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

    Route::group(['namespace' => 'Auth'], function () {
        /**
         * Login
         */
        Route::post('/login', 'AuthController@login');
    });

    Route::group(['namespace' => 'Api'], function () {

        /**
         * Bookings
         */
        Route::post('/bookings', 'BookingController@create');

    });

    /**
     * Authenticated Requests
     */
    Route::middleware('jwt.auth')->group(function () {

        Route::group(['namespace' => 'Auth'], function () {
            /**
             * Logout
             */
            Route::post('/logout', 'AuthController@logout');

        });

    Route::group(['namespace' => 'Api'], function () {
        /**
         * Hotels
         */
        Route::get('/items', 'HotelController@index');
        Route::get('/items/{id}', 'HotelController@show');
        Route::post('/items', 'HotelController@create');
        Route::put('/items/{id}', 'HotelController@update');
        Route::delete('/items/{id}', 'HotelController@destroy');
    });
});
