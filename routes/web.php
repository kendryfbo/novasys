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

Route::get('/email', 'Comercial\ComercialController@email')->name('email');


// GRUPO de Rutas Api
/* CAMBIAR a archivo routes/api.php */
Route::group(['prefix' => 'api'], function(){

	Route::get('/marcas',	'MarcaController@getMarcas')->name('listaMarcas');
	Route::get('/formatos',	'FormatoController@getFormatos')->name('listaFormatos');
	Route::get('/sabores',	'SaborController@getSabores')->name('listaSabores');
	Route::post('/insumos', 'InsumoController@getInsumos')->name('listaInsumos');
	Route::post('/formula', 'FormulaController@getFormula')->name('getFormula');
	Route::post('/producto/formato', 'ProductoController@getFormatoProducto')->name('formatoProducto');
});
