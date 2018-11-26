<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('finanzas')->group( function() {

    route::get('/', 'Finanzas\FinanzasController@index')->name('finanzas');

    // Autorizaciones
    Route::prefix('autorizacion')->group( function() {

        // Autorizacion de Proformas
        route::get('/proforma',                          'Finanzas\FinanzasController@authPF')->name('autFinanzasPF');
        route::get('/proforma/{proforma}',               'Finanzas\FinanzasController@showAuthFinanzasPF')->name('verAutFinanzasPF');
        route::post('/proforma/{proforma}/autorizar',    'Finanzas\FinanzasController@authorizePF')->name('autorizarFinanzasPF');
        route::post('/proforma/{proforma}/desautorizar', 'Finanzas\FinanzasController@unauthorizePF')->name('desautorizarFinanzasPF');

        // Autorizacion de Notas de Venta
        route::get('/notaVenta',                           'Finanzas\FinanzasController@authNV')->name('autFinanzasNV');
        route::get('/notaVenta/{notaVenta}',               'Finanzas\FinanzasController@showAuthFinanzasNV')->name('verAutFinanzasNV');
        route::post('/notaVenta/{notaVenta}/autorizar',    'Finanzas\FinanzasController@authorizeNV')->name('autorizarFinanzasNV');
        route::post('/notaVenta/{notaVenta}/desautorizar', 'Finanzas\FinanzasController@unauthorizeNV')->name('desautorizarFinanzasNV');

        // Autorizacion de Orden de Compra
        route::get('/ordenCompra',                             'Finanzas\FinanzasController@authOC')->name('autFinanzasOC');
        route::get('/ordenCompra/{ordenCompra}',               'Finanzas\FinanzasController@showAuthFinanzasOC')->name('verAutFinanzasOC');
        route::post('/ordenCompra/{ordenCompra}/autorizar',    'Finanzas\FinanzasController@authorizeOC')->name('autorizarFinanzasOC');
        route::post('/ordenCompra/{ordenCompra}/desautorizar', 'Finanzas\FinanzasController@unauthorizeOC')->name('desautorizarFinanzasOC');

    });

    // Abonos Internacionales
    Route::prefix('abonosIntl')->group( function() {

        route::get('/',                     'Finanzas\AbonosIntlController@index')->name('abonosIntl');
        route::get('/crearAbono',           'Finanzas\AbonosIntlController@create')->name('crearAbonoIntl');
        route::post('/guardaAbono',         'Finanzas\AbonosIntlController@store')->name('guardaAbonoIntl');

    });



    // Pagos Internacionales
    Route::prefix('pagosIntl')->group( function() {

        route::get('/',                          'Finanzas\PagosIntlController@index')->name('pagosIntl');
        route::get('/crear',                     'Finanzas\PagosIntlController@create')->name('pagarIntl');
        route::post('/guardaPago',               'Finanzas\PagosIntlController@store')->name('guardaPagoIntl');
        route::get('/historial',                 'Finanzas\PagosIntlController@historial')->name('historialPagoIntl');
        route::get('/facturasPorCobrar',         'Finanzas\PagosIntlController@porCobrar')->name('pagoPorCobrar');
        route::post('/facturasPorCobrar',        'Finanzas\PagosIntlController@porCobrar')->name('pagoPorCobrar');
        route::get('/anularFact',                'Finanzas\PagosIntlController@anularPagoIntl')->name('anulaPagoIntl');

    });


});

 ?>
