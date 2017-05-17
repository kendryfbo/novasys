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
	// GRUPO de Rutas de Desarrollo/Sabores
	Route::group(['prefix' => 'sabores'], function(){

		Route::get('/',					'SaborController@index')->name('sabores');
		Route::get('crear', 			'SaborController@create')->name('crearSabor');
		Route::post('/', 				'SaborController@store')->name('guardarSabor');
		Route::get('/{sabor}/edit', 	'SaborController@edit')->name('editarSabor');
		Route::post('update/{sabor}', 	'SaborController@update')->name('actualizarSabor');
		Route::post('delete/{sabor}', 	'SaborController@destroy')->name('eliminarSabor');

	});
	// GRUPO de Rutas de Desarrollo/Formatos
	Route::group(['prefix' => 'formatos'], function(){

		Route::get('/',					'FormatoController@index')->name('formatos');
		Route::get('crear', 			'FormatoController@create')->name('crearFormato');
		Route::post('/', 				'FormatoController@store')->name('guardarFormato');
		Route::get('/{formato}/edit', 	'FormatoController@edit')->name('editarFormato');
		Route::post('update/{formato}', 'FormatoController@update')->name('actualizarFormato');
		Route::post('delete/{formato}', 'FormatoController@destroy')->name('eliminarFormato');

	});
	// GRUPO de Rutas de Desarrollo/Productos
	Route::group(['prefix' => 'productos'], function(){

		Route::get('/',					'ProductoController@index')->name('productos');
		Route::get('crear', 			'ProductoController@create')->name('crearProducto');
		Route::post('/', 				'ProductoController@store')->name('guardarProducto');
		Route::get('/{producto}/edit', 	'ProductoController@edit')->name('editarProducto');
		Route::post('update/{producto}', 'ProductoController@update')->name('actualizarProducto');
		Route::post('delete/{producto}', 'ProductoController@destroy')->name('eliminarProducto');

	});
	// GRUPO de Rutas de Desarrollo/Premezcla
	Route::group(['prefix' => 'premezclas'], function(){

		Route::get('/',					'PremezclaController@index')->name('premezclas');
		Route::get('crear', 			'PremezclaController@create')->name('crearPremezcla');
		Route::post('/', 				'PremezclaController@store')->name('guardarPremezcla');
		Route::get('/{premezcla}/edit', 	'PremezclaController@edit')->name('editarPremezcla');
		Route::post('update/{premezcla}', 'PremezclaController@update')->name('actualizarPremezcla');
		Route::post('delete/{premezcla}', 'PremezclaController@destroy')->name('eliminarPremezcla');

	});
	// GRUPO de Rutas de Desarrollo/Insumo
	Route::group(['prefix' => 'insumos'], function(){

		Route::get('/',					'InsumoController@index')->name('insumos');
		Route::get('crear', 			'InsumoController@create')->name('crearInsumo');
		Route::post('/', 				'InsumoController@store')->name('guardarInsumo');
		Route::get('/{insumo}/edit', 	'InsumoController@edit')->name('editarInsumo');
		Route::post('update/{insumo}', 'InsumoController@update')->name('actualizarInsumo');
		Route::post('delete/{insumo}', 'InsumoController@destroy')->name('eliminarInsumo');

	});
});

Route::group(['prefix' => 'api'], function(){

	Route::get('/marcas',	'MarcaController@getMarcas')->name('listaMarcas');
	Route::get('/formatos',	'FormatoController@getFormatos')->name('listaFormatos');
	Route::get('/sabores',	'SaborController@getSabores')->name('listaSabores');
});
