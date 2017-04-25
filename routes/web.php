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

Route::get('/', 'MainController@index');
Route::get('welcome', function (){
	return view('vue');
});
// GRUPO de Rutas de Modulo de desarrollo
Route::group(['prefix' => 'desarrollo'], function(){

	// Pantalla Principal Modulo Desarrollo
	Route::get('/', 'DesarrolloController@main');

	// GRUPO de Rutas de Desarrollo/Familias
	Route::group(['prefix' => 'familias'], function(){

		Route::get('/',					'FamiliaController@index')->name('familias');
		Route::get('create', 			'FamiliaController@create')->name('crearFamilia');
		Route::post('/', 				'FamiliaController@store')->name('guardarFamilia');
		Route::get('/{familia}/edit', 	'FamiliaController@edit')->name('editarFamilia');
		Route::post('update/{familia}', 'FamiliaController@update')->name('actualizarFamilia');
		Route::post('delete/{familia}', 'FamiliaController@destroy')->name('eliminarFamilia');

	});
	// GRUPO de Rutas de Desarrollo/Marcas
	Route::group(['prefix' => 'marcas'], function(){

		Route::get('/','MarcaController@index')->name('marcas');
		Route::get('crear', 'MarcaController@create')->name('crearMarca');
		Route::post('store', 'MarcaController@store')->name('guardarMarca');

	});

});
