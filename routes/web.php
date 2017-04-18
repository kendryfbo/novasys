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

Route::get('/', 'MainController@index')->name('index');

// se mantiene para test, debe ser eliminada
Route::get('welcome', function(){

	return view('welcome');

});

Route::get('gerencia', function(){
	if (Gate::allows('gerencia',Route::currentRouteName())){
		return view('gerencia.index');
	} else {
		return redirect()->back();
	}

})->name('gerencia');

Route::get('login','Auth\AccessoController@login')->name('login');
Route::get('form-login','Auth\AccessoController@formLogin')->name('form-login');

Route::get('logout', 'MainController@logout')->name('logout');
