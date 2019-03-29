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
    Route::get('/{client}/projects/', 'ProjectsController@index')->name('projects.index');
    Route::post('/{client}/projects/', 'ProjectsController@store')->name('projects.store');
    Route::get('/{client}/projects/create', 'ProjectsController@create')->name('projects.create');
});

Route::group([
    'prefix' => 'projects',
    'middleware' => 'auth'
], function () {
    // Route::get('/', 'ProjectsController@index')->name('projects.index');
    // Route::post('/', 'ProjectsController@store')->name('projects.store');
    // Route::get('/create', 'ProjectsController@create')->name('projects.create');
    Route::get('/{project}', 'ProjectsController@show')->name('projects.show');
    Route::get('/{project}/edit', 'ProjectsController@edit')->name('projects.edit');
    Route::post('/{project}/edit', 'ProjectsController@update')->name('projects.update');
    Route::get('/{project}/timers', 'TimersController@index')->name('timers.index');
});

Route::group([
    'prefix' => 'timers',
    'middleware' => 'auth'
], function () {
    // Route::get('/', 'TimersController@index')->name('timers.index');
    // Route::post('/', 'TimersController@store')->name('timers.store');
    // Route::get('/create', 'TimersController@create')->name('timers.create');
    // Route::get('/{timer}', 'TimersController@show')->name('timers.show');
    // Route::get('/{timer}/edit', 'TimersController@edit')->name('timers.edit');
    // Route::post('/{timer}/edit', 'TimersController@update')->name('timers.update');
});
