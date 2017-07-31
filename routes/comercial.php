<?php

// GRUPO de Rutas de Modulo Comercial
Route::middleware('auth')->prefix('comercial')->group( function(){

	// Pantalla Principal Modulo Comercial
    Route::get('/',         'Comercial\ComercialController@main');

    // Test Excel y PDF
	Route::get('/excel',    'Comercial\ComercialController@excel');
	Route::get('/pdf',      'Comercial\ComercialController@pdf');
	Route::get('/email',      'Comercial\ComercialController@email');

	// Resource Vendedores
	Route::resource('vendedores','Comercial\VendedorController',[
		'except' => ['show'],
		'parameters' => [
			'vendedores' => 'vendedor'],
	]);

	// Resource Clientes Nacionales
	Route::resource('clientesNacionales','Comercial\ClienteNacionalController',[
		'parameters' => ['clientesNacionales' => 'cliente']]);

	// Resource Lista de Precios
	Route::resource('listaPrecios','Comercial\ListaPrecioController',[
		'parameters' => ['listaPrecios' => 'listaPrecio']]);


    // Resource Nota de Venta
	Route::get('notasVentas/autorizacion',              'Comercial\NotaVentaController@authorization');
	Route::get('notasVentas/{notaVenta}/autorizar',     'Comercial\NotaVentaController@showForAut');
	Route::post('notasVentas/autorizar/{notaVenta}',    'Comercial\NotaVentaController@authorizeNotaVenta');
	Route::post('notasVentas/desautorizar/{notaVenta}', 'Comercial\NotaVentaController@unauthorizedNotaVenta');
	Route::resource('notasVentas','Comercial\NotaVentaController',[
		'parameters' => ['notasVentas' => 'notaVenta']]);

    // Resource Factura Nacionale
    Route::prefix('facturasNacionales')->group(function(){

        Route::get('/',           'Comercial\FacturaNacionalController@index');
        Route::post('/guardar',   'Comercial\FacturaNacionalController@store')->name('guardarFacNac');
        Route::post('/guardarNV', 'Comercial\FacturaNacionalController@storeFromNV')->name('guardarFacNacNV');
        Route::get('/crear',      'Comercial\FacturaNacionalController@create')->name('crearFacturaNacional');
        Route::post('/crear',     'Comercial\FacturaNacionalController@createFromNotaVenta')->name('crearFacturaNacionalNV');
    });




});
