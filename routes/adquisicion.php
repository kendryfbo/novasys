<?php
use App\Models\FormulaDetalle;


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('adquisicion')->group( function() {

    // Proveedores
    Route::prefix('proveedores')->group( function() {

        Route::get('/',                   'Adquisicion\ProveedorController@index')->name('proveedores');
        Route::get('/crear',              'Adquisicion\ProveedorController@create')->name('crearProveedor');
        Route::post('/',                  'Adquisicion\ProveedorController@store')->name('guardarProveedor');
        Route::get('/{proveedor}/editar', 'Adquisicion\ProveedorController@edit')->name('editarProveedor');
        Route::get('/{proveedor}',        'Adquisicion\ProveedorController@show')->name('verProveedor');
        Route::put('/{proveedor}',        'Adquisicion\ProveedorController@update')->name('actualizarProveedor');
        Route::delete('/{proveedor}',     'Adquisicion\ProveedorController@destroy')->name('eliminarProveedor');
    });

    // Formas de pago de Proveedores
    Route::prefix('formaPago')->group(function() {

        Route::get('/crear',          'Adquisicion\FormaPagoProveedorController@create')->name('crearFormaPagoProveedor');
        Route::get('/',               'Adquisicion\FormaPagoProveedorController@index')->name('formaPagoProveedor');
        Route::get('/{formaPago}',    'Adquisicion\FormaPagoProveedorController@show')->name('verFormaPagoProveedor');
        Route::post('/',              'Adquisicion\FormaPagoProveedorController@store')->name('guardarFormaPagoProveedor');
        Route::get('/editar',         'Adquisicion\FormaPagoProveedorController@edit')->name('editarFormaPagoProveedor');
        Route::put('/{formaPago}',    'Adquisicion\FormaPagoProveedorController@update')->name('actualizarFormaPagoProveedor');
        Route::delete('/{formaPago}', 'Adquisicion\FormaPagoProveedorController@destroy')->name('eliminarFormaPagoProveedor');
    });

    Route::prefix('ordenCompra')->group(function() {

        Route::get('/pendientes',                'Adquisicion\OrdenCompraController@indexPending')->name('ordenCompraPendiente');
        Route::get('/crear',                     'Adquisicion\OrdenCompraController@create')->name('crearOrdenCompra');
        Route::get('/',                          'Adquisicion\OrdenCompraController@index')->name('ordenCompra');
        Route::get('/{numero}',                  'Adquisicion\OrdenCompraController@show')->name('verOrdenCompra');
        Route::get('/{numero}/pdf',              'Adquisicion\OrdenCompraController@pdf')->name('verOrdenCompraPDF');
        Route::get('/{numero}/descargar',        'Adquisicion\OrdenCompraController@downloadPDF')->name('descargarOrdenCompraPDF');
        Route::get('/pendientes/download',       'Adquisicion\OrdenCompraController@downloadPendingOCPDF')->name('descargarOrdenCompraPendientePDF');
        Route::post('/',                         'Adquisicion\OrdenCompraController@store')->name('guardarOrdenCompra');
        Route::get('{numero}/editar',            'Adquisicion\OrdenCompraController@edit')->name('editarOrdenCompra');
        Route::put('/{ordenCompra}',             'Adquisicion\OrdenCompraController@update')->name('actualizarOrdenCompra');
        Route::delete('/{ordenCompra}',          'Adquisicion\OrdenCompraController@destroy')->name('eliminarOrdenCompra');
        Route::post('/{ordenCompra}/completa',   'Adquisicion\OrdenCompraController@complete')->name('ordenCompraCompleta');
        Route::post('/{ordenCompra}/incompleta', 'Adquisicion\OrdenCompraController@incomplete')->name('ordenCompraIncompleta');
        Route::post('/{numero}/email',           'Adquisicion\OrdenCompraController@sendEmail')->name('enviarEmailOrdenCompra');

        // Reportes
        Route::get('/reporte/productos',          'Adquisicion\OrdenCompraReportController@reporteProductos')->name('reporteProductos');
        Route::post('/reporte/productos/descarga','Adquisicion\OrdenCompraReportController@excelReport')->name('descargaReporteProductos');
        Route::get('/reporte/proveedor', 'Adquisicion\OrdenCompraReportController@reportProveedor')->name('reporteOrdenCompraProveedor');
        Route::post('/reporte/proveedor', 'Adquisicion\OrdenCompraReportController@reportProveedor')->name('reporteOrdenCompraProveedor');
        Route::post('/reporte/proveedor/descarga', 'Adquisicion\OrdenCompraReportController@reportProveedorDownloadPDF')->name('descargarReporteOrdenCompraProveedorPDF');
        Route::post('/reporte/proveedor/descargaDetalle', 'Adquisicion\OrdenCompraReportController@reportDetProveedorDownloadPDF')->name('descargarReporteDetOrdenCompraProveedorPDF');
        Route::get('/reporte/insumos', 'Adquisicion\OrdenCompraReportController@reportInsumos')->name('reporteOrdenCompraInsumo');
        Route::post('/reporte/insumos', 'Adquisicion\OrdenCompraReportController@reportInsumos')->name('reporteOrdenCompraInsumo');
        Route::post('/reporte/insumos/descarga', 'Adquisicion\OrdenCompraReportController@reportInsumosDownloadPDF')->name('descargarReporteOrdenCompraInsumoPDF');


    });

    Route::prefix('planProduccion')->group( function(){

        Route::get('/',                  'Adquisicion\PlanProduccionController@index')->name('planProduccion');
        Route::get('/crear',             'Adquisicion\PlanProduccionController@create')->name('crearPlanProduccion');
        Route::post('/',                 'Adquisicion\PlanProduccionController@store')->name('guardarPlanProduccion');
        Route::get('/{id}',              'Adquisicion\PlanProduccionController@show')->name('verPlanProduccion');
        Route::post('/{id}/duplicar',    'Adquisicion\PlanProduccionController@duplicate')->name('duplicarPlanProduccion');
        Route::post('/{id}/editar',      'Adquisicion\PlanProduccionController@edit')->name('editarPlanProduccion');
        Route::post('/actualizar',       'Adquisicion\PlanProduccionController@update')->name('actualizarPlanProduccion');
        Route::delete('/{id}',           'Adquisicion\PlanProduccionController@destroy')->name('eliminarPlanProduccion');
        Route::post('/AnalisisConStock', 'Adquisicion\PlanProduccionController@showAnalReqWithStock')->name('verPlanProduccionConStock');
        Route::post('/AnalisisSinStock', 'Adquisicion\PlanProduccionController@showAnalReqWithoutStock')->name('verPlanProduccionSinStock');
        Route::post('/descExcelAnalReq', 'Adquisicion\PlanProduccionController@downloadExcelAnalReq')->name('descExcelAnalReq');
        Route::post('/descExcelAnalReqConStock','Adquisicion\PlanProduccionController@downloadExcelAnalReqConStock')->name('descExcelAnalReqConStock');
    });



        Route::prefix('costoProducto')->group( function(){

            Route::get('/',                                 'Adquisicion\CostoProductoController@index')->name('costosProducto');
            //Route::post('/',                                'Adquisicion\CostoProductoController@index')->name('costosProducto');
            Route::post('/',                                'Adquisicion\CostoProductoController@downloadExcel')->name('descargarCostoProductoExcel');

        });

});

 ?>
