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
    Route::prefix('clientesNacionales')->group(function(){

        Route::get('/',                        'Comercial\ClienteNacionalController@index')->name('clientesNacionales');
        Route::get('/crear',                   'Comercial\ClienteNacionalController@create')->name('crearClientesNacionales');
        Route::post('/crear',                  'Comercial\ClienteNacionalController@store')->name('guardarClientesNacionales');
        Route::get('{cliente}/editar', 'Comercial\ClienteNacionalController@edit')->name('editarClientesNacionales');
        Route::put('{cliente}/editar', 'Comercial\ClienteNacionalController@update')->name('actualizarClientesNacionales');
        Route::delete('/{cliente}',    'Comercial\ClienteNacionalController@delete')->name('eliminarClientesNacionales');
    });

	// Resource Lista de Precios
	Route::resource('listaPrecios','Comercial\ListaPrecioController',[
		'parameters' => ['listaPrecios' => 'listaPrecio']]);


    // Resource Nota de Venta
	Route::get('notasVentas/autorizacion',              'Comercial\NotaVentaController@authorization')->name('autNotaVenta');
	Route::get('notasVentas/{notaVenta}/autorizar',     'Comercial\NotaVentaController@showForAut')->name('verAutNotaVenta');
	Route::post('notasVentas/autorizar/{notaVenta}',    'Comercial\NotaVentaController@authorizeNotaVenta')->name('autorizarNotaVenta');
	Route::post('notasVentas/desautorizar/{notaVenta}', 'Comercial\NotaVentaController@unauthorizedNotaVenta')->name('desautNotaVenta');
	Route::put('notasVentas/{notaVenta}',               'Comercial\NotaVentaController@update')->name('actualizarNotaVenta');
	Route::resource('notasVentas','Comercial\NotaVentaController',[
		'parameters' => ['notasVentas' => 'notaVenta']]);

  // Resource Factura Nacionale
  Route::prefix('facturasNacionales')->group(function(){

      Route::get('/',           'Comercial\FacturaNacionalController@index');
      Route::get('/crear',      'Comercial\FacturaNacionalController@create')->name('crearFacturaNacional');
      Route::post('/crear',     'Comercial\FacturaNacionalController@createFromNV')->name('crearFactNacFromNV');
      Route::post('/guardar',   'Comercial\FacturaNacionalController@store')->name('guardarFacNac');
      Route::post('/guardarNV', 'Comercial\FacturaNacionalController@storeFromNV')->name('guardarFacNacNV');
  });

  // Resource Forma de Pago Nacional
  Route::resource('formasPagos', 'Comercial\FormaPagoNacController', [
    'parameters' => ['formasPago' => 'formaPago']]);

  // Routes Forma Pago Internacionales
  Route::get('FormasPagosIntl', 'Comercial\FormaPagoIntlController@index')->name('formaPagoIntl');
  Route::get('FormasPagosIntl/crear', 'Comercial\FormaPagoIntlController@create')->name('crearFormaPagoIntl');
  Route::post('FormasPagosIntl', 'Comercial\FormaPagoIntlController@store')->name('guardarFormaPagoIntl');

  // Routes Clientes Internacionales
  Route::prefix('clientesIntl')->group( function() {

      Route::get('/',                   'Comercial\ClienteIntlController@index')->name('clienteIntl');
      Route::get('/{clienteIntl}',      'Comercial\ClienteIntlController@show')->name('verClienteIntl');
      Route::get('/crear',              'Comercial\ClienteIntlController@create')->name('crearClienteIntl');
      Route::post('/',                  'Comercial\ClienteIntlController@store')->name('guardarClienteIntl');
      Route::get('/{clienteIntl}/edit', 'Comercial\ClienteIntlController@edit')->name('editarClienteIntl');
      Route::put('/{clienteIntl}/edit', 'Comercial\ClienteIntlController@update')->name('actualizarClienteIntl');
      Route::delete('/{clienteIntl}',   'Comercial\ClienteIntlController@destroy')->name('eliminarClienteIntl');
  });

  // Routes Aduanas
  Route::get('aduanas',               'Comercial\AduanaController@index')->name('aduana');
  Route::get('aduanas/crear',         'Comercial\AduanaController@create')->name('crearAduana');
  Route::post('aduanas',              'Comercial\AduanaController@store')->name('guardarAduana');
  Route::get('aduanas/{aduana}/edit', 'Comercial\AduanaController@edit')->name('editarAduana');
  Route::put('aduanas/{aduana}',      'Comercial\AduanaController@update')->name('actualizarAduana');
  Route::get('aduanas/{aduana}',      'Comercial\AduanaController@show')->name('verAduana');
  Route::delete('aduanas/{aduana}',   'Comercial\AduanaController@destroy')->name('eliminarAduana');

  // Puerto Embarque
  Route::get('puertosEmbarque',                        'Comercial\PuertoEmbarqueController@index')->name('puertoEmbarque');
  Route::get('puertosEmbarque/crear',                  'Comercial\PuertoEmbarqueController@create')->name('crearPuertoEmbarque');
  Route::post('puertosEmbarque',                       'Comercial\PuertoEmbarqueController@store')->name('guardarPuertoEmbarque');
  Route::get('puertosEmbarque/{puertoEmbarque}/edit',  'Comercial\PuertoEmbarqueController@edit')->name('editarPuertoEmbarque');
  Route::put('puertosEmbarque/{puertoEmbarque}',       'Comercial\PuertoEmbarqueController@update')->name('actualizarPuertoEmbarque');
  Route::delete('puertosEmbarque/{puertoEmbarque}',    'Comercial\PuertoEmbarqueController@destroy')->name('EliminarPuertoEmbarque');

  // Routes Proforma
  Route::get('proformas',                           'Comercial\ProformaController@index')->name('proforma');
  Route::get('proformas/crear',                     'Comercial\ProformaController@create')->name('crearProforma');
  Route::post('proformas/crear',                    'Comercial\ProformaController@createImport')->name('crearDeProforma');
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
