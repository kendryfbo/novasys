<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('adquisicion')->group( function() {

    // Proveedores
    Route::prefix('proveedores')->group( function() {

        route::get('/', function() {
            dd('proveedor');
        });
        Route::get('/',                   'Adquisicion\ProveedorController@index')->name('proveedores');
        Route::get('/crear',              'Adquisicion\ProveedorController@create')->name('crearProveedor');
        Route::post('/',                  'Adquisicion\ProveedorController@store')->name('guardarProveedor');
        Route::get('/{proveedor}/editar', 'Adquisicion\ProveedorController@edit')->name('editarProveedor');
        Route::get('/{proveedor}',        'Adquisicion\ProveedorController@show')->name('verProveedor');
        Route::put('/',                   'Adquisicion\ProveedorController@update')->name('actualizarProveedor');
        Route::delete('/',                'Adquisicion\ProveedorController@delete')->name('eliminarProveedor');
    });


});

 ?>
