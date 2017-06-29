<?php

// GRUPO de Rutas de Modulo Comercial
Route::middleware('auth')->prefix('comercial')->group( function(){

	// Pantalla Principal Modulo Comercial
    Route::get('/', 'Comercial\ComercialController@main');
	Route::get('/excel', 'Comercial\ComercialController@excel');
	Route::get('/pdf', 'Comercial\ComercialController@pdf');
	// Resource Vendedores
	Route::resource('vendedores','Comercial\VendedorController',[
		'except' => ['show'],
		'parameters' => [
			'vendedores' => 'vendedor'],
	]);
	// Resource Clientes Nacionales
	Route::resource('clientesNacionales','Comercial\ClienteNacionalController',[
		'parameters' => [
			'clientesNacionales' => 'cliente']
	]);
	// Resource Lista de Precios
	Route::resource('listaPrecios','Comercial\ListaPrecioController',[
		'parameters' => [
			'listaPrecios' => 'listaPrecio']
	]);

	Route::get('notasVentas/autorizacion', 'Comercial\NotaVentaController@authorization');
	Route::post('notasVentas/autorizar/{notaVenta}', 'Comercial\NotaVentaController@authorizeNotaVenta');
	Route::post('notasVentas/desautorizar/{notaVenta}', 'Comercial\NotaVentaController@unauthorizedNotaVenta');
	// Resource Nota de Venta
	Route::resource('notasVentas','Comercial\NotaVentaController',[
		'parameters' => [
			'notasVentas' => 'notaVenta']
	]);

    // Resource Factura Nacionale
    Route::prefix('facturasNacionales')->group(function(){

        Route::get('/', 'Comercial\FacturaNacionalController@index');
        Route::get('/crear', 'Comercial\FacturaNacionalController@create')->name('crearFacturaNacional');
        Route::post('/crear', 'Comercial\FacturaNacionalController@createFromNotaVenta')->name('crearFacturaNacionalNV');
        Route::post('/', 'Comercial\FacturaNacionalController@store')->name('guardarFacturaNacional');
    });




});
