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
});


 ?>
