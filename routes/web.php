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

		Route::get('/',					'MarcaController@index')->name('marcas');
		Route::get('crear', 			'MarcaController@create')->name('crearMarca');
		Route::post('/', 				'MarcaController@store')->name('guardarMarca');
		Route::get('/{marca}/edit', 	'MarcaController@edit')->name('editarMarca');
		Route::post('update/{marca}', 	'MarcaController@update')->name('actualizarMarca');
		Route::post('delete/{marca}', 	'MarcaController@destroy')->name('eliminarMarca');

	});

	Route::group(['prefix' => 'sabores'], function(){

		Route::get('/',					'SaborController@index')->name('sabores');
		Route::get('crear', 			'SaborController@create')->name('crearSabor');
		Route::post('/', 				'SaborController@store')->name('guardarSabor');
		Route::get('/{sabor}/edit', 	'SaborController@edit')->name('editarSabor');
		Route::post('update/{sabor}', 	'SaborController@update')->name('actualizarSabor');
		Route::post('delete/{sabor}', 	'SaborController@destroy')->name('eliminarSabor');

	});

	Route::group(['prefix' => 'formatos'], function(){

		Route::get('/',					'FormatoController@index')->name('formatos');
		Route::get('crear', 			'FormatoController@create')->name('crearFormato');
		Route::post('/', 				'FormatoController@store')->name('guardarFormato');
		Route::get('/{formato}/edit', 	'FormatoController@edit')->name('editarFormato');
		Route::post('update/{formato}', 'FormatoController@update')->name('actualizarFormato');
		Route::post('delete/{formato}', 'FormatoController@destroy')->name('eliminarFormato');

	});

});
