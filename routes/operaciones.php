<?php


// GRUPO de Rutas de Modulo Operaciones
Route::prefix('operaciones')->group( function(){

    // Pantalla Principal Modulo Operaciones
    Route::get('/', function(){

        return view('operaciones.main');
    });
});

 ?>
