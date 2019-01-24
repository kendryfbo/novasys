<?php

// Rutas Api Facturas Internacionales
route::post('facturasIntl/Cliente',    'Api\ApiFacturaIntlController@getFacturaIntlByClient')->name('apiObtainFacturasByClienteIntl');
route::post('facturasIntl/Historial',  'Api\ApiFacturaIntlController@getHistorialIntlByClient')->name('apiObtainHistorialByClienteIntl');
route::post('facturasIntl/PorCobrar',  'Api\ApiFacturaIntlController@getFacturasPorCobrar')->name('apiObtainFacturasIntlPorCobrar');
route::post('facturasIntl/Anular',     'Api\ApiFacturaIntlController@getFacturaPorAnular')->name('apiObtainFacturaIntlPorAnular');

// Rutas Api Facturas Internacionales
route::post('abonosIntl/Cliente',    'Api\ApiAbonosIntlController@getAbonoIntlByClient')->name('apiObtainAbonosByClienteIntl');

// Rutas Api Facturas Nacionales
route::post('facturasNacional/Cliente',    'Api\ApiFacturaNacionalController@getFacturaNacionalByClient')->name('apiObtainFacturasByClienteNacional');
route::post('facturasNacional/Historial',  'Api\ApiFacturaNacionalController@getHistorialNacionalByClient')->name('apiObtainHistorialByClienteNacional');
route::post('facturasNacional/PorCobrar',  'Api\ApiFacturaNacionalController@getFacturasPorCobrar')->name('apiObtainFacturasNacionalPorCobrar');
route::post('facturasNacional/Anular',     'Api\ApiFacturaNacionalController@getFacturaPorAnular')->name('apiObtainFacturaNacionalPorAnular');

// Rutas Api Facturas Naccionales
route::post('abonosNacional/Cliente',    'Api\ApiAbonosNacionalController@getAbonoNacionalByClient')->name('apiObtainAbonosByClienteNacional');
