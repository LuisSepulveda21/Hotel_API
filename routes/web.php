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

Route::resource('hotels', 'HotelController'); //Muestra todo los hoteles
Route::get('hotel','HotelController@find'); //Buscar hoteles
Route::post('user','UsersController@store');  //Crea usuario
Route::put('user/{id}','UsersController@update'); //Actualizar usuario
Route::post('reservation','ReservationController@store'); //Crea reservacion
Route::get('check','ReservationController@check'); //Comprobar disponibilidad
Route::post('storekey', 'KeysapiController@store'); //Crear Api key
Route::put('update/{id}', 'HotelController@update'); //Actualiza hotel
Route::delete('destroy/{id}', 'HotelController@destroy'); //Eliminar hotel
Route::post('store', 'HotelController@store'); //Crear Hotel
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
