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

Route::group([
    'prefix' => 'clients',
    'middleware' => 'auth'
], function () {
    Route::get('/', 'ClientsController@index')->name('clients.index');
    Route::post('/', 'ClientsController@store')->name('clients.store');
    Route::get('/create', 'ClientsController@create')->name('clients.create');
    Route::get('/{client}', 'ClientsController@show')->name('clients.show');
    Route::get('/{client}/edit', 'ClientsController@edit')->name('clients.edit');
    Route::post('/{client}/edit', 'ClientsController@update')->name('clients.update');
});
