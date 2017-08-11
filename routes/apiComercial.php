<?php

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

// Rutas api Notas de Ventas
route::get('notasVentas', 'Api\NotaVentaController@index');
route::get('notasVentas/{notaVenta}', 'Api\NotaVentaController@show');


// Rutas Api Sucursales Internacionales
route::get('sucursalesIntl/{cliente}', 'Api\SucursalIntlController@show')->name('apiVerSucursalClienteIntl');
route::post('sucursalesIntl/{cliente}', 'Api\SucursalIntlController@store')->name('apiGuardarSucursalClienteIntl');
