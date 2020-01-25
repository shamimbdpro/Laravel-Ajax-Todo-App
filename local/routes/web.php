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


Route::get('/', 'TodoController@index');


Route::get('delteAll', 'TodoController@delteAll')->name('delteAll');
Route::get('deactive/{id}', 'TodoController@deactive')->name('deactive');
Route::get('active/{id}', 'TodoController@active')->name('active');
Route::resource('todos', 'TodoController');