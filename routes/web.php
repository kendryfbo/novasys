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
Route::get('/', 'MainController@index')->name('main');
Route::get('/ingresar', 'Config\AuthenticationController@signIn')->name('signin');
Route::post('/login', 'Config\AuthenticationController@login')->name('login');
Route::get('/logout', 'Config\AuthenticationController@logout')->name('logout');
