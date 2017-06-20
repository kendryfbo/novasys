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
Route::resource('formulaDetalle','Api\FormulaDetalleController', [
    'only' =>['index','store','show','update','destroy']
]);

// Rutas Api de Provincias
Route::resource('provincias', 'Api\ProvinciaController', [
    'only' => ['index']
]);

// Rutas Api de Comunas
Route::resource('comunas', 'Api\ComunaController', [
    'only' => ['index']
]);

// Rutas Api de Sucursales
Route::post('sucursales/insertar', 'Api\SucursalController@insert');
Route::get('sucursales/{cliente}', 'Api\SucursalController@index');
Route::resource('sucursales', 'Api\SucursalController', [
    'only' => ['index','store','update','destroy','insert'],
    'parameters' => [
        'sucursales' => 'sucursal']
]);

// Rutas Api de Clientes Nacionales
Route::get('clientesNacionales/{cliente}', 'Api\ClienteNacionalController@show');

// Rutas Api de Lista de Precios
Route::get('listaPrecios/{lista}', 'Api\ListaPrecioController@show');
Route::post('listaPreciosDetalle/insertar', 'Api\ListaPrecioDetalleController@insert');
Route::get('listaPreciosDetalle/{lista}'  , 'Api\ListaPrecioDetalleController@index');
Route::resource('listaPreciosDetalle', 'Api\ListaPrecioDetalleController', [
    'only' => ['index','store','update','destroy','insert'],
    'parameters' => [
        'listaPreciosDetalle' => 'detalle']
]);

Route::get('formulaDetalle/formula/{id}', 'Api\FormulaDetalleController@getFormula');
Route::post('formulaDetalle/insertar', 'Api\FormulaDetalleController@insert');
Route::post('formulaDetalle/importar', 'Api\FormulaDetalleController@import');
