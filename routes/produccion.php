<?php
// GRUPO de Rutas de Modulo Operaciones-Produccion
Route::prefix('produccion')->group( function(){


    // Termino de Proceso
    Route::prefix('terminoProceso')->group(function() {

        Route::get('/crear',        'Produccion\TerminoProcesoController@create')->name('crearTerminoProceso');
        Route::get('/',             'Produccion\TerminoProcesoController@index')->name('terminoProceso');
        Route::post('/',            'Produccion\TerminoProcesoController@store')->name('guardarTerminoProceso');
        Route::get('/{terminoProceso}/edit', 'Produccion\TerminoProcesoController@edit')->name('editarTerminoProceso');
        Route::delete('/{id}',      'Produccion\TerminoProcesoController@destroy')->name('eliminarTerminoProceso');

    });

    // Produccion Premezcla
    Route::prefix('premezcla')->group(function() {

        Route::post('/',              'Produccion\ProduccionPremezclaController@store')->name('guardarProduccionPremezcla');
        Route::get('/',               'Produccion\ProduccionPremezclaController@index')->name('produccionPremezcla');
        Route::get('/crear',          'Produccion\ProduccionPremezclaController@create')->name('crearProduccionPremezcla');
        Route::get('/{id}/edit',      'Produccion\ProduccionPremezclaController@edit')->name('editarProduccionPremezcla');
        Route::delete('/{id}',        'Produccion\ProduccionPremezclaController@destroy')->name('eliminarProduccionPremezcla');
        Route::get('/{id}/descontar', 'Produccion\ProduccionPremezclaController@createDescProdPremezcla')->name('crearDescProdPremezcla');
        Route::post('/{id}',          'Produccion\ProduccionPremezclaController@storeDescProdPremezcla')->name('guardarDescProdPremezcla');

    });
});


 ?>
