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

/**
 * Mobile Routes
 */
Route::post('register/donor','BloodDonorController@register');
Route::post('donate/blood','BloodDonorController@donate');
Route::post('get/donors','BloodDonorController@getNearbyDonors');
Route::post('unavailable/donor','BloodDonorController@unavailable');

/**
 * Music routes
 */

Route::post('add/music','MusicController@upload');
Route::post('show/music','MusicController@list');

