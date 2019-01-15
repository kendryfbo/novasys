<?php

// Rutas Api Facturas Internacionales
route::post('facturasIntl/Cliente',    'Api\ApiFacturaIntlController@getFacturaIntlByClient')->name('apiObtainFacturasByClienteIntl');
route::post('facturasIntl/Historial',  'Api\ApiFacturaIntlController@getHistorialIntlByClient')->name('apiObtainHistorialByClienteIntl');
route::post('facturasIntl/PorCobrar',  'Api\ApiFacturaIntlController@getFacturasPorCobrar')->name('apiObtainFacturasIntlPorCobrar');
route::post('facturasIntl/Anular',     'Api\ApiFacturaIntlController@getFacturaPorAnular')->name('apiObtainFacturaIntlPorAnular');

// Rutas Api Facturas Internacionales
route::post('abonosIntl/Cliente',    'Api\ApiAbonosIntlController@getAbonoIntlByClient')->name('apiObtainAbonosByClienteIntl');
