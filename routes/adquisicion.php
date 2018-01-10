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
        Route::put('/{proveedor}',        'Adquisicion\ProveedorController@update')->name('actualizarProveedor');
        Route::delete('/{proveedor}',     'Adquisicion\ProveedorController@destroy')->name('eliminarProveedor');
    });

    // Formas de pago de Proveedores
    Route::prefix('formaPago')->group(function() {

        Route::get('/crear',          'Adquisicion\FormaPagoProveedorController@create')->name('crearFormaPagoProveedor');
        Route::get('/',               'Adquisicion\FormaPagoProveedorController@index')->name('formaPagoProveedor');
        Route::get('/{formaPago}',    'Adquisicion\FormaPagoProveedorController@show')->name('verFormaPagoProveedor');
        Route::post('/',              'Adquisicion\FormaPagoProveedorController@store')->name('guardarFormaPagoProveedor');
        Route::get('/editar',         'Adquisicion\FormaPagoProveedorController@edit')->name('editarFormaPagoProveedor');
        Route::put('/{formaPago}',    'Adquisicion\FormaPagoProveedorController@update')->name('actualizarFormaPagoProveedor');
        Route::delete('/{formaPago}', 'Adquisicion\FormaPagoProveedorController@destroy')->name('eliminarFormaPagoProveedor');
    });

    Route::prefix('ordenCompra')->group(function() {

        Route::get('/crear',       'Adquisicion\OrdenCompraController@create')->name('crearOrdenCompra');
        Route::get('/',            'Adquisicion\OrdenCompraController@index')->name('ordenCompra');
        Route::get('/{numero}',    'Adquisicion\OrdenCompraController@show')->name('verOrdenCompra');
        Route::post('/',           'Adquisicion\OrdenCompraController@store')->name('guardarOrdenCompra');
        Route::get('{numero}/editar',      'Adquisicion\OrdenCompraController@edit')->name('editarOrdenCompra');
        Route::put('/{numero}',    'Adquisicion\OrdenCompraController@update')->name('actualizarOrdenCompra');
        Route::delete('/{numero}', 'Adquisicion\OrdenCompraController@destroy')->name('eliminarOrdenCompra');
    });
});

 ?>
