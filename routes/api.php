<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas Api de Detalles de Formula

// comentadas hasta revision de retro compatibilidad - luego eliminar
/*
Route::resource('formulaDetalle','Api\FormulaDetalleController', [
    'only' =>['index','store','show','update','destroy']
]);

Route::get('formulaDetalle/formula/{id}', 'Api\FormulaDetalleController@getFormula')->name('apiObtenerFormula');
Route::post('formulaDetalle/insertar', 'Api\FormulaDetalleController@insert')->name('apiInsertarFormula');
Route::post('formulaDetalle/importar', 'Api\FormulaDetalleController@import')->name('apiImportarFormula');
*/

	Route::get('/marcas',	'MarcaController@getMarcas')->name('listaMarcas');
	Route::get('/formatos',	'FormatoController@getFormatos')->name('listaFormatos');
	Route::get('/sabores',	'SaborController@getSabores')->name('listaSabores');
	Route::post('/insumos', 'InsumoController@getInsumos')->name('listaInsumos');
	Route::post('/formula', 'FormulaController@getFormula')->name('getFormula');
	Route::post('/producto/formato', 'ProductoController@getFormatoProducto')->name('formatoProducto');
