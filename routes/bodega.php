<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('bodega')->group( function(){

    // Resource Pallets
    Route::prefix('pallet')->group(function(){

        Route::get('/', 'Bodega\PalletController@test');

        Route::get('/porIngresar',        'Bodega\PalletController@index')->name('palletPorIngresar');
        Route::get('/{pallet}/pdf',       'Bodega\PalletController@pdfPalletProd')->name('etiquetaPalletProduccion');
        Route::get('/{id}/findPosition/', 'Bodega\PalletController@position')->name('position'); // TEST
        Route::get('/materiaPrima/crear', 'Bodega\PalletController@createPalletMateriaPrima')->name('crearPalletMP');
        Route::get('/materiaPrima',       'Bodega\PalletController@indexPalletMateriaPrima')->name('PalletMP');

    });
    Route::get('/creacionPalletProduccion', 'Bodega\PalletController@createPalletProduccion')->name('crearPalletProduccion');
    Route::post('/creacionPalletProduccion', 'Bodega\PalletController@storePalletProduccion')->name('guardarPalletProduccion');
    Route::get('/ingresoManual', 'Bodega\PalletController@create')->name('crearPallet');



    // this should be declared in API controller
    Route::get('/getOpciones/{condicion}',  'Bodega\CondPosController@getOpcionesFromTipo')->name('getopcionesDeCondicion');
    Route::get('/getCondicion/{posicion}',  'Bodega\CondPosController@getCondicionOfPos')->name('getCondicionDePosicion');
    Route::post('/posicion/condicion',      'Bodega\CondPosController@store')->name('guardarCondicion');
    Route::post('/posicion/status',         'Bodega\PosicionController@storeStatus')->name('guardarStatusPosicion');
    Route::post('/posicion/pallet',         'Bodega\PosicionController@getPallet')->name('obtenerPalletDePosicion');

    Route::get('/config',         'Bodega\BodegaController@indexConfig')->name('configBodega');
    Route::get('/',               'Bodega\BodegaController@index')->name('bodega');
    Route::get('/crear',          'Bodega\BodegaController@create')->name('crearBodega');
    Route::get('/{id}/config',    'Bodega\BodegaController@edit')->name('editarBodega');
    Route::get('/{id}/consultar', 'Bodega\BodegaController@consult')->name('consultarBodega');
    Route::post('/',              'Bodega\BodegaController@store')->name('guardarBodega');
});


 ?>
