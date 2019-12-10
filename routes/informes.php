<?php

Route::prefix('informes')->group(function()
{

    route::get('/', 'Informes\InformesController@main')->name('informes');

    // GRUPO de Rutas de Calidad\NoConformidades
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

});
