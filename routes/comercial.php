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
	Route::get('notasVentas/autorizacion',              'Comercial\NotaVentaController@authorization')->name('autNotaVenta');
	Route::get('notasVentas/{notaVenta}/autorizar',     'Comercial\NotaVentaController@showForAut')->name('verAutNotaVenta');
	Route::post('notasVentas/autorizar/{notaVenta}',    'Comercial\NotaVentaController@authorizeNotaVenta')->name('autorizarNotaVenta');
	Route::post('notasVentas/desautorizar/{notaVenta}', 'Comercial\NotaVentaController@unauthorizedNotaVenta')->name('desautNotaVenta');
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

  // Resource Forma de Pago Nacional
  Route::resource('formasPagos', 'Comercial\FormaPagoNacController', [
    'parameters' => ['formasPago' => 'formaPago']]);

  // Routes Forma Pago Internacionales
  Route::get('FormasPagosIntl', 'Comercial\FormaPagoIntlController@index')->name('formaPagoIntl');
  Route::get('FormasPagosIntl/crear', 'Comercial\FormaPagoIntlController@create')->name('crearFormaPagoIntl');
  Route::post('FormasPagosIntl', 'Comercial\FormaPagoIntlController@store')->name('guardarFormaPagoIntl');

  // Routes Clientes Internacionales
  Route::get('clientesIntl',                    'Comercial\ClienteIntlController@index')->name('clienteIntl');
  Route::get('clientesIntl/crear',              'Comercial\ClienteIntlController@create')->name('crearClienteIntl');
  Route::post('clientesIntl',                   'Comercial\ClienteIntlController@store')->name('guardarClienteIntl');
  Route::get('clientesIntl/{clienteIntl}/edit', 'Comercial\ClienteIntlController@edit')->name('editarClienteIntl');
  Route::get('clientesIntl/{clienteIntl}', 'Comercial\ClienteIntlController@show')->name('verClienteIntl');
  Route::delete('clientesIntl/{clienteIntl}', 'Comercial\ClienteIntlController@destroy')->name('eliminarClienteIntl');

  // Routes Aduanas
  Route::get('aduanas',               'Comercial\AduanaController@index')->name('aduana');
  Route::get('aduanas/crear',         'Comercial\AduanaController@create')->name('crearAduana');
  Route::post('aduanas',              'Comercial\AduanaController@store')->name('guardarAduana');
  Route::get('aduanas/{aduana}/edit', 'Comercial\AduanaController@edit')->name('editarAduana');
  Route::get('aduanas/{aduana}',      'Comercial\AduanaController@show')->name('verAduana');
  Route::delete('aduanas/{aduana}',   'Comercial\AduanaController@destroy')->name('eliminarAduana');

  // Routes Proforma
  Route::get('proformas',                           'Comercial\ProformaController@index')->name('proforma');
  Route::get('proformas/crear',                     'Comercial\ProformaController@create')->name('crearProforma');
  Route::post('proformas',                          'Comercial\ProformaController@store')->name('guardarProforma');
  Route::get('proformas/{proforma}/editar',         'Comercial\ProformaController@edit')->name('editarProforma');
  Route::put('proformas/{proforma}',                'Comercial\ProformaController@update')->name('actualizarProforma');
  Route::get('proformas/{proforma}',                'Comercial\ProformaController@show')->name('verProforma');
  Route::delete('proformas/{proforma}',             'Comercial\ProformaController@delete')->name('eliminarProforma');
  Route::get('proformas/{proforma}/autorizacion',   'Comercial\ProformaController@showForAut')->name('autorizarProforma');
  Route::post('proformas/{proforma}/autorizar',     'Comercial\ProformaController@authorize')->name('autorizarProforma');
  Route::post('proformas/{proforma}/desautorizar',  'Comercial\ProformaController@unAuthorize')->name('desautorizarProforma');

  // Routes Guia de Despacho Internacionales
  route::get('guiaDespacho',                    'GuiaDespachoController@index')->name('guiaDespacho');
  route::get('guiaDespacho/crear/{proforma?}',  'GuiaDespachoController@create')->name('crearGuiaDespacho');
  route::post('guiaDespacho',                   'GuiaDespachoController@store')->name('guardarGuiaDespacho');
  route::get('guiaDespacho/{guia}',             'GuiaDespachoController@show')->name('verGuiaDespacho');
  route::get('guiaDespacho/{guia}/pdf',         'GuiaDespachoController@pdf')->name('pdfGuiaDespacho');

  // Routes Facturas Internacionales
  Route::post('FacturaIntl/importarProforma', 'Comercial\FacturaIntlController@importProforma')->name('importProformaFactIntl');
  Route::get('FacturaIntl/crear',             'Comercial\FacturaIntlController@create')->name('crearFacturaIntl');
  Route::get('FacturaIntl/{facturaIntl}',    'Comercial\FacturaIntlController@show')->name('verFacturaIntl');
  Route::get('FacturaIntl/{facturaIntl}/descargar',    'Comercial\FacturaIntlController@download')->name('descargarFacturaIntl');
  Route::post('FacturaIntl',                  'Comercial\FacturaIntlController@store')->name('guardarFacturaIntl');
  Route::post('FacturaIntl/{proforma}',       'Comercial\FacturaIntlController@storeFromProforma')->name('guardarFacturaIntlProforma');

  // Routes Facturas SII Internacionales
  /* Temporal */
  Route::get('facturaIntlSII/crear', function() {

    $centrosVenta = [];
    $clientes = [];
    $clausulas = [];
    $transportes = [];
    $productos = [];
    $aduanas = [];
    return view('comercial.facturaIntlSII.create')->with([
      'centrosVenta' => $centrosVenta,
      'clientes' => $clientes,
      'clausulas' => $clausulas,
      'transportes' => $transportes,
      'aduanas' => $aduanas,
      'productos' => $productos
    ]);

  });

  // Routes PackingList Internacionales
  Route::get('packingList/crear/{guia?}','Comercial\PackingListController@create')->name('crearPackingList');
  Route::post('packingList/pdf','Comercial\PackingListController@pdf')->name('pdfPackingList');
});
