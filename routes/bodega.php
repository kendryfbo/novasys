<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('bodega')->group( function(){

    Route::get('/getOpciones/{condicion}',  'Bodega\CondPosController@getOpcionesFromTipo')->name('getopcionesDeCondicion');
    Route::get('/getCondicion/{posicion}',  'Bodega\CondPosController@getCondicionOfPos')->name('getCondicionDePosicion');
    Route::post('/posicion/condicion',      'Bodega\CondPosController@store')->name('guardarCondicion');
    Route::post('/posicion/status',         'Bodega\PosicionController@storeStatus')->name('guardarStatusPosicion');

    Route::get('/crear',      'Bodega\BodegaController@create')->name('crearBodega');
    Route::get('/{id}',       'Bodega\BodegaController@show')->name('verBodega');
    Route::get('/',           'Bodega\BodegaController@index')->name('bodega');
    Route::post('/',          'Bodega\BodegaController@store')->name('guardarBodega');

});


 ?>
