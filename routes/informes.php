<?php

Route::prefix('informes')->group(function()
{

    route::get('/', 'Informes\InformesController@main')->name('informes');

    // GRUPO de Rutas de
    Route::group(['prefix' => 'ventasPorMes'], function()
    {
        route::get('/',                     'Informes\InformesController@index')->name('ventasPorMes');
        route::post('/',                    'Informes\InformesController@ventasMensuales')->name('ventasPorMes');
        route::get('/nacional',             'Informes\InformesController@ventasMensualesNacional')->name('ventasNacionales');
        route::post('/nacional',            'Informes\InformesController@ventasMensualesNacional')->name('ventasNacionales');
        route::get('/internacional',        'Informes\InformesController@ventasMensualesInternacional')->name('ventasInternacionales');
        route::post('/internacional',       'Informes\InformesController@ventasMensualesInternacional')->name('ventasInternacionales');
        route::post('/reporteTotal',        'Informes\InformesController@ventasReportTotalExcel')->name('descargaReporteVentasTotalExcel');
    });
    // GRUPO de Rutas de Cierre de mes
    Route::group(['prefix' => 'cierreMes'], function()
    {
        route::get('/total',                     'Informes\InformesController@cierreMesTotal')->name('cierreMesTotal');
        route::get('/internacional',        'Informes\InformesController@cierreMesIntl')->name('cierreMesIntl');
        route::get('/nacional',             'Informes\InformesController@cierreMesNacional')->name('cierreMesNacional');
    });


});
