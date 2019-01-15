<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiBodegaController;

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

Route::prefix('bodega')->group( function() {

    Route::get('/', function() {
        return 'hola';
    });
    //Route::get('/', 'Api\ApiBodegaController@asd');
    Route::get('/',                      'Api\ApiBodegaController@getBodegasWithPos')->name('apiObtenerBodegaConPosiciones');
    Route::get('/posConPallet',          'Api\ApiBodegaController@getBodegasPosWithPallet')->name('apiObtenerBodegaConPosiciones');
    Route::post('/posiciones',           'Api\ApiBodegaController@getPositionsFrom')->name('apiObtenerPosicionDeBodega');
    Route::post('/stockTipoDesdeBodega', 'Api\ApiBodegaController@getExistTipoFromBodega')->name('apiStockTipoDesdeBodega');
    Route::post('/consult',              'Api\ApiBodegaController@consult')->name('apiConsultarBodega');
    Route::post('/bloquearPos',          'Api\ApiBodegaController@blockBodegaPosition')->name('apiBloqPosBodega');
    Route::post('/desbloquearPos',       'Api\ApiBodegaController@unBlockBodegaPosition')->name('apiDesBloqPosBodega');
});
