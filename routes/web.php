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

Route::post('donor/register/donor','BloodDonorController@register');
Route::post('donor/donate/blood','BloodDonorController@donate');
Route::post('donor/get/donors','BloodDonorController@getNearbyDonors');
Route::post('donor/unavailable/donor','BloodDonorController@unavailable');
