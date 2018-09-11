<?php

// GRUPO de Rutas de Modulo Comercial
Route::middleware('auth')->prefix('comercial')->group( function(){

	// Pantalla Principal Modulo Comercial
    Route::get('/',         'Comercial\ComercialController@main')->name('comercial');

    // Test Excel y PDF
	Route::get('/excel',    'Comercial\ComercialController@excel')->name('testExcel');
	Route::get('/pdf',      'Comercial\ComercialController@pdf')->name('testPDF');
	Route::get('/email',      'Comercial\ComercialController@email')->name('testEmail');

	// Resource Vendedores
	Route::resource('vendedores','Comercial\VendedorController',[
		'except' => ['show'],
		'parameters' => [
			'vendedores' => 'vendedor'],
	]);

	// Resource Clientes Nacionales
    Route::prefix('clientesNacionales')->group(function(){

        Route::get('/',                'Comercial\ClienteNacionalController@index')->name('clientesNacionales');
        Route::get('/crear',           'Comercial\ClienteNacionalController@create')->name('crearClientesNacionales');
        Route::post('/crear',          'Comercial\ClienteNacionalController@store')->name('guardarClientesNacionales');
        Route::get('{cliente}/editar', 'Comercial\ClienteNacionalController@edit')->name('editarClientesNacionales');
        Route::put('{cliente}/editar', 'Comercial\ClienteNacionalController@update')->name('actualizarClientesNacionales');
        Route::delete('/{cliente}',    'Comercial\ClienteNacionalController@destroy')->name('eliminarClientesNacionales');
    });

	// Resource Lista de Precios
	Route::resource('listaPrecios','Comercial\ListaPrecioController',[
		'parameters' => ['listaPrecios' => 'listaPrecio']]);


    // Resource Nota de Venta
    Route::prefix('notaVenta')->group(function(){

        route::get('/',                          'Comercial\NotaVentaController@index')->name('notaVenta');
        route::get('/crear',                     'Comercial\NotaVentaController@create')->name('crearNotaVenta');
        route::post('/',                         'Comercial\NotaVentaController@store')->name('guardarNotaVenta');
        Route::get('/autorizacion',              'Comercial\NotaVentaController@authorization')->name('autNotaVenta');
        Route::get('/{notaVenta}/autorizar',     'Comercial\NotaVentaController@showForAut')->name('verAutNotaVenta');
        Route::get('/{numero}/pdf',              'Comercial\NotaVentaController@downloadPDF')->name('descargarNotaVentaPDF');
        Route::post('/autorizar/{notaVenta}',    'Comercial\NotaVentaController@authorizeNotaVenta')->name('autorizarNotaVenta');
        Route::post('/desautorizar/{notaVenta}', 'Comercial\NotaVentaController@unauthorizedNotaVenta')->name('desautNotaVenta');
        Route::put('/{notaVenta}',               'Comercial\NotaVentaController@update')->name('actualizarNotaVenta');
        route::get('/{numero}/editar',           'Comercial\NotaVentaController@edit')->name('editarNotaVenta');
        route::get('/{numero}',                  'Comercial\NotaVentaController@show')->name('verNotaVenta');
        route::delete('/{notaVenta}',              'Comercial\NotaVentaController@destroy')->name('eliminarNotaVenta');
    });

  // Resource Factura Nacionale
  Route::prefix('facturasNacionales')->group(function(){

      Route::get('/',                    'Comercial\FacturaNacionalController@index')->name('factNac');
      Route::get('/crear',               'Comercial\FacturaNacionalController@create')->name('crearFactNac');
      Route::post('/crear',              'Comercial\FacturaNacionalController@createFromNV')->name('crearFactNacFromNV');
      Route::get('/{factura}',           'Comercial\FacturaNacionalController@show')->name('verFactNac');
      Route::get('/{factura}/descargar', 'Comercial\FacturaNacionalController@download')->name('descargarFacturaNac');
      Route::post('/guardar',            'Comercial\FacturaNacionalController@store')->name('guardarFactNac');
      Route::post('/guardarNV',          'Comercial\FacturaNacionalController@storeFromNV')->name('guardarFactNacFromNV');
      Route::delete('/{factura}',        'Comercial\FacturaNacionalController@destroy')->name('eliminarFactNac');
  });

  // Resource Forma de Pago Nacional
  Route::resource('formasPagos', 'Comercial\FormaPagoNacController', [
    'parameters' => ['formasPago' => 'formaPago']]);

  // Routes Forma Pago Internacionales
  Route::get('FormasPagosIntl', 'Comercial\FormaPagoIntlController@index')->name('formaPagoIntl');
  Route::get('FormasPagosIntl/crear', 'Comercial\FormaPagoIntlController@create')->name('crearFormaPagoIntl');
  Route::post('FormasPagosIntl', 'Comercial\FormaPagoIntlController@store')->name('guardarFormaPagoIntl');

  // Routes Clientes Internacionales
  Route::prefix('clientesIntl')->group(function() {

      Route::get('/',                   'Comercial\ClienteIntlController@index')->name('clienteIntl');
      Route::get('/crear',              'Comercial\ClienteIntlController@create')->name('crearClienteIntl');
      Route::get('/{clienteIntl}',      'Comercial\ClienteIntlController@show')->name('verClienteIntl');
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
  Route::get('proformas/autorizacion/',             'Comercial\ProformaController@authorization')->name('autorizacionProforma');
  Route::get('proformas/{proforma}',                'Comercial\ProformaController@show')->name('verProforma');
  Route::get('proformas/{numero}/pdf',              'Comercial\ProformaController@downloadPDF')->name('descargarProformaPDF');
  Route::delete('proformas/{proforma}',             'Comercial\ProformaController@destroy')->name('eliminarProforma');
  Route::get('proformas/autorizacion/{proforma}',   'Comercial\ProformaController@showForAut')->name('autorizarProforma');
  Route::post('proformas/autorizar/{numero}',       'Comercial\ProformaController@auth')->name('autorizarProforma');
  Route::post('proformas/desautorizar/{numero}',    'Comercial\ProformaController@unauth')->name('desautorizarProforma');

    // Routes Guia de Despacho Internacionales
    route::prefix('guiaDespacho')->group(function(){

        route::get('/',                    'GuiaDespachoController@index')->name('guiaDespacho');
        route::get('crear/{proforma?}',  'GuiaDespachoController@create')->name('crearGuiaDespacho');
        route::post('/',                   'GuiaDespachoController@store')->name('guardarGuiaDespacho');
        route::get('{guia}',             'GuiaDespachoController@show')->name('verGuiaDespacho');
        route::delete('{guia}',          'GuiaDespachoController@destroy')->name('eliminarGuiaDespacho');
        route::get('{guia}/pdf',         'GuiaDespachoController@pdf')->name('pdfGuiaDespacho');
    });
    // Routes Facturas Internacionales
    Route::prefix('FacturaIntl')->group(function(){

      Route::get('{id}/descargarPDF',        'Comercial\FacturaIntlController@downloadPDF')->name('descargarFacturaIntlPDF');
      Route::get('{id}/descargarSIIPDF',        'Comercial\FacturaIntlController@downloadSIIPDF')->name('descargarFacturaIntlSIIPDF');
      Route::get('/',                          'Comercial\FacturaIntlController@index')->name('FacturaIntl');
      Route::post('importarProforma',          'Comercial\FacturaIntlController@importProforma')->name('importProformaFactIntl');
      Route::get('crear',                      'Comercial\FacturaIntlController@create')->name('crearFacturaIntl');
      Route::get('{numero}',                   'Comercial\FacturaIntlController@show')->name('verFacturaIntl');
      Route::get('{facturaIntl}/descargar',    'Comercial\FacturaIntlController@download')->name('descargarFacturaIntl');
      Route::post('/',                         'Comercial\FacturaIntlController@store')->name('guardarFacturaIntl');
      Route::post('{proforma}',                'Comercial\FacturaIntlController@storeFromProforma')->name('guardarFacturaIntlProforma');
      Route::delete('{numero}',                'Comercial\FacturaIntlController@destroy')->name('eliminarFActuraIntl');

    });

    // Notas de Credito Nacionales
    Route::prefix('notasCreditoNac')->group(function() {

        Route::get('/',                            'Comercial\NotaCreditoNacController@index')->name('notaCreditoNac');
        Route::post('/',                           'Comercial\NotaCreditoNacController@store')->name('guardarNotaCreditoNac');
        Route::post('/cliente',                    'Comercial\NotaCreditoNacController@storeToCliente')->name('guardarNotaCreditoNacCliente');
        Route::get('/crearParaCliente',            'Comercial\NotaCreditoNacController@createToCliente')->name('crearNotaCreditoNacCliente');
        Route::get('/crear/{factura?}',            'Comercial\NotaCreditoNacController@create')->name('crearNotaCreditoNac');
        Route::get('/autorizacion',                'Comercial\NotaCreditoNacController@authorization')->name('autorizacionNotaCreditoNac');
        Route::get('/{notaCredito}',               'Comercial\NotaCreditoNacController@show')->name('verNotaCreditoNac');
        Route::put('/{notaCredito}',               'Comercial\NotaCreditoNacController@update')->name('actualizarNotaCreditoNac');
        Route::delete('/{notaCredito}',            'Comercial\NotaCreditoNacController@destroy')->name('eliminarNotaCreditoNac');
        Route::get('/{notaCredito}/editar',        'Comercial\NotaCreditoNacController@edit')->name('editarNotaCreditoNac');
        Route::get('/autorizacion/{notaCredito}',  'Comercial\NotaCreditoNacController@showForAuth')->name('autorizarNotaCreditoNac');
        Route::post('/autorizar/{notaCredito}',    'Comercial\NotaCreditoNacController@auth')->name('autorizarNotaCreditoNac');
        Route::post('/desautorizar/{notaCredito}', 'Comercial\NotaCreditoNacController@unauth')->name('desautorizarNotaCreditoNac');

    });

    // Notas de Debito Nacionales
    Route::prefix('notasDebitoNac')->group(function() {

        Route::get('/',                            'Comercial\NotaDebitoNacController@index')->name('notaDebitoNac');
        Route::post('/',                           'Comercial\NotaDebitoNacController@store')->name('guardarNotaDebitoNac');
        Route::get('/crear/{notaCredito?}',        'Comercial\NotaDebitoNacController@create')->name('crearNotaDebitoNac');
        //Route::get('/autorizacion',                'Comercial\NotaDebitoNacController@authorization')->name('autorizacionNotaDebitoNac');
        Route::get('/{numero}',                    'Comercial\NotaDebitoNacController@show')->name('verNotaDebitoNac');
        //Route::put('/{notaDebito}',               'Comercial\NotaDebitoNacController@update')->name('actualizarNotaDebitoNac');
        Route::delete('/{notaDebito}',             'Comercial\NotaDebitoNacController@destroy')->name('eliminarNotaDebitoNac');
        //Route::get('/{notaDebito}/editar',        'Comercial\NotaDebitoNacController@edit')->name('editarNotaDebitoNac');
        //Route::get('/autorizacion/{notaDebito}',  'Comercial\NotaDebitoNacController@showForAuth')->name('autorizarNotaDebitoNac');
        //Route::post('/autorizar/{notaDebito}',    'Comercial\NotaDebitoNacController@auth')->name('autorizarNotaDebitoNac');
        //Route::post('/desautorizar/{notaDebito}', 'Comercial\NotaDebitoNacController@unauth')->name('desautorizarNotaDebitoNac');

    });

    // Notas de Credito Internacioneles
    Route::prefix('notasCreditoIntl')->group(function() {

        Route::get('/',                     'Comercial\NotaCreditoIntlController@index')->name('notaCreditoIntl');
        Route::post('/',                    'Comercial\NotaCreditoIntlController@store')->name('guardarNotaCreditoIntl');
        Route::get('/crear/{factura?}',     'Comercial\NotaCreditoIntlController@create')->name('crearNotaCreditoIntl');
        Route::get('/{numero}',             'Comercial\NotaCreditoIntlController@show')->name('verNotaCreditoIntl');
        Route::put('/{notaCredito}',        'Comercial\NotaCreditoIntlController@update')->name('actualizarNotaCreditoIntl');
        Route::delete('/{notaCredito}',     'Comercial\NotaCreditoIntlController@destroy')->name('eliminarNotaCreditoIntl');
        Route::get('/{notaCredito}/editar', 'Comercial\NotaCreditoIntlController@edit')->name('editarNotaCreditoIntl');

    });

    // Notas de Debito Intl
    Route::prefix('notasDebitoIntl')->group(function() {

        Route::get('/',                            'Comercial\NotaDebitoIntlController@index')->name('notaDebitoIntl');
        Route::post('/',                           'Comercial\NotaDebitoIntlController@store')->name('guardarNotaDebitoIntl');
        Route::get('/crear/{notaCredito?}',        'Comercial\NotaDebitoIntlController@create')->name('crearNotaDebitoIntl');
        //Route::get('/autorizacion',                'Comercial\NotaDebitoIntlController@authorization')->name('autorizacionNotaDebitoIntl');
        Route::get('/{numero}',                    'Comercial\NotaDebitoIntlController@show')->name('verNotaDebitoIntl');
        //Route::put('/{notaDebito}',               'Comercial\NotaDebitoIntlController@update')->name('actualizarNotaDebitoIntl');
        Route::delete('/{notaDebito}',             'Comercial\NotaDebitoIntlController@destroy')->name('eliminarNotaDebitoIntl');
        //Route::get('/{notaDebito}/editar',        'Comercial\NotaDebitoIntlController@edit')->name('editarNotaDebitoIntl');
        //Route::get('/autorizacion/{notaDebito}',  'Comercial\NotaDebitoIntlController@showForAuth')->name('autorizarNotaDebitoIntl');
        //Route::post('/autorizar/{notaDebito}',    'Comercial\NotaDebitoIntlController@auth')->name('autorizarNotaDebitoIntl');
        //Route::post('/desautorizar/{notaDebito}', 'Comercial\NotaDebitoIntlController@unauth')->name('desautorizarNotaDebitoIntl');

    });

    // Routes Facturas SII Internacionales
    /* Temporal */
    Route::prefix('facturaIntlSII')->group(function () {

        Route::get('/',         'Comercial\FacturaIntlSIIController@index')->name('facturaIntlSII');
        Route::get('/{numero}', 'Comercial\FacturaIntlSIIController@show')->name('verFacturaIntlSII');
    });

    // Routes PackingList Internacionales
    Route::get('packingList/crear/{guia?}','Comercial\PackingListController@create')->name('crearPackingList');
    Route::post('packingList/pdf','Comercial\PackingListController@pdf')->name('pdfPackingList');

    // Reportes Nacionales
    Route::prefix('informesNac')->group(function() {

        Route::get('/facturaNac',      'Comercial\ReportNacController@reportFact')->name('verInformeNacFactura');
        Route::post('/facturaNac',     'Comercial\ReportNacController@reportFact')->name('verInformeNacFactura');
        Route::post('/reportFact',     'Comercial\ReportNacController@reportFactExcel')->name('ReportFactNacExcel');
        Route::post('/reportProd',     'Comercial\ReportNacController@reportProdExcel')->name('ReportProdNacExcel');
        Route::get('/facturaNacProd',  'Comercial\ReportNacController@reportProdFact')->name('verInformeNacProdFactura');
        Route::post('/facturaNacProd', 'Comercial\ReportNacController@reportProdFact')->name('verInformeNacProdFactura');
        Route::get('/NotaVenta',       'Comercial\ReportNacController@reportnotaVenta')->name('verInformeNotaVenta');
        Route::post('/NotaVenta',      'Comercial\ReportNacController@reportnotaVenta')->name('verInformeNotaVenta');
        Route::get('/NotaVenta/descargar', 'Comercial\ReportNacController@downloadExcelNotaVenta')->name('descargarInformeNotaVenta');

    });

    // Reportes Internacioneles
    Route::prefix('informesIntl')->group(function() {

        //Route::get('/',               'Comercial\ReportIntlController@proforma')->name('informesIntl');
        Route::get('/proformas',        'Comercial\ReportIntlController@proforma')->name('verInformeIntlProforma');
        Route::post('/proformas',       'Comercial\ReportIntlController@proforma')->name('verInformeIntlProforma');
        Route::get('/facturaIntl',      'Comercial\ReportIntlController@reportFact')->name('verInformeIntlFactura');
        Route::post('/facturaIntl',     'Comercial\ReportIntlController@reportFact')->name('verInformeIntlFactura');
        Route::post('/reportFact',       'Comercial\ReportIntlController@reportFactExcel')->name('descargarReportFactExcel');
        Route::post('/reportProd',       'Comercial\ReportIntlController@reportProdExcel')->name('descargarReportProdExcel');
        Route::get('/facturaIntlProd',  'Comercial\ReportIntlController@reportProdFact')->name('verInformeIntlProdFactura');
        Route::post('/facturaIntlProd', 'Comercial\ReportIntlController@reportProdFact')->name('verInformeIntlProdFactura');

    });

});
