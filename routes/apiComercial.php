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
Route::post('sucursales/insertar', 'Api\SucursalController@insert')->name('apiInsertarSucursal');
Route::get('sucursales/{cliente}', 'Api\SucursalController@index')->name('apiIndexSucursal');
Route::resource('sucursales', 'Api\SucursalController', [
    'only' => ['index','store','update','destroy','insert'],
    'parameters' => [
        'sucursales' => 'sucursal']
]);

// Rutas Api de Clientes Nacionales
Route::get('clientesNacionales/{cliente}', 'Api\ClienteNacionalController@show')->name('apiVerClientenNacional');

// Rutas Api de Lista de Precios
Route::get('listaPrecios/{lista}', 'Api\ListaPrecioController@show')->name('apiVerListaPrecio');
Route::post('listaPreciosDetalle/insertar', 'Api\ListaPrecioDetalleController@insert')->name('apiInsertarListaPrecio');
Route::get('listaPreciosDetalle/{lista}'  , 'Api\ListaPrecioDetalleController@index')->name('apiIndexListaPrecio');
Route::resource('listaPreciosDetalle', 'Api\ListaPrecioDetalleController', [
    'only' => ['index','store','update','destroy','insert'],
    'parameters' => [
        'listaPreciosDetalle' => 'detalle']
]);

// Rutas api Notas de Ventas
route::get('notasVentas', 'Api\NotaVentaController@index')->name('apiIndexNotaVenta');
route::get('notasVentas/{notaVenta}', 'Api\NotaVentaController@show')->name('apiVerNotaVenta');


// Rutas Api Sucursales Internacionales
route::get('sucursalesClienteIntl/{cliente}', 'Api\SucursalIntlController@show')->name('apiVerSucursalClienteIntl');
route::post('sucursalesClienteIntl/{cliente}', 'Api\SucursalIntlController@store')->name('apiGuardarSucursalClienteIntl');
route::put('sucursalesClienteIntl/{cliente}', 'Api\SucursalIntlController@update')->name('apiActualizarSucursalClienteIntl');
route::delete('sucursalesClienteIntl/{id}', 'Api\SucursalIntlController@destroy')->name('apiEliminarSucursalClienteIntl');

// Rutas Api Facturas Internacionales
route::post('facturasIntl/Cliente',    'Api\ApiFacturaIntlController@getFacturaIntlByClient')->name('apiObtainFacturasByClienteIntl');
route::post('facturasIntl/Historial',  'Api\ApiFacturaIntlController@getHistorialIntlByClient')->name('apiObtainHistorialByClienteIntl');
route::post('facturasIntl/PorCobrar',  'Api\ApiFacturaIntlController@getFacturasPorCobrar')->name('apiObtainFacturasIntlPorCobrar');
route::post('facturasIntl/Anular',     'Api\ApiFacturaIntlController@getFacturaPorAnular')->name('apiObtainFacturaIntlPorAnular');

// Rutas Api Facturas Internacionales
route::post('abonosIntl/Cliente',    'Api\ApiAbonosIntlController@getAbonoIntlByClient')->name('apiObtainAbonosByClienteIntl');
