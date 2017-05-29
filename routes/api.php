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

Route::resource('formulaDetalle','Api\FormulaDetalleController', ['only' =>[
    'index','store','show','update','destroy'
]]);

Route::get('formulaDetalle/formula/{id}', 'Api\FormulaDetalleController@getFormula');
Route::post('formulaDetalle/insertar', 'Api\FormulaDetalleController@insert');
Route::post('formulaDetalle/importar', 'Api\FormulaDetalleController@import');
