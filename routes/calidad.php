<?php

Route::prefix('sgcalidad')->group(function()
{

    route::get('/', 'Calidad\CalidadController@main')->name('sgcalidad');

    // GRUPO de Rutas de Calidad\NoConformidades
    Route::group(['prefix' => 'NoConformidades'], function()
    {
        route::get('/',                     'Calidad\CalidadController@index')->name('NoConformidades');
        route::get('/crear',                'Calidad\CalidadController@create')->name('crearNoConformidad');
        route::post('/',                    'Calidad\CalidadController@store')->name('guardarNoConformidad');
        route::get('/{id}/editar',          'Calidad\CalidadController@edit')->name('editarNoConformidad');
        route::post('/{id}',                'Calidad\CalidadController@update')->name('actualizarNoConformidad');
        route::get('/lista_administrador',  'Calidad\CalidadController@list_admin')->name('administraList');
        route::get('/{id}/administra',      'Calidad\CalidadController@administra')->name('administrarNoConformidad');
        route::post('/{id}/cierre',         'Calidad\CalidadController@actualiza')->name('cierreNoConformidad');
        route::get('/{id}/pdf',             'Calidad\CalidadController@downloadPDF')->name('descargarNoConformidadPDF');
        route::get('/nc/{id}',              'Calidad\CalidadController@show')->name('verNoConformidad');
        route::post('/{id}/email',          'Calidad\CalidadController@sendEmail')->name('enviarNoConformidad');
        route::get('/descargar',            'Calidad\CalidadController@downloadExcel')->name('descargarNoConformidadesExcel');
    });

    Route::group(['prefix' => 'Documentos'], function()
    {
        route::get('/',                     'Calidad\DocumentosCalidadController@index')->name('documentosCalidad');
        route::get('/acceso',               'Calidad\DocumentosCalidadController@DocumentProfileAccess')->name('AccesodocumentosCalidad');
        route::get('/crear',                'Calidad\DocumentosCalidadController@create')->name('crearDocumentosCalidad');
        route::post('/',                    'Calidad\DocumentosCalidadController@store')->name('guardarDocumentosCalidad');
        route::get('/{id}/editar',          'Calidad\DocumentosCalidadController@edit')->name('editarDocsPDF');
        route::post('/{id}',                'Calidad\DocumentosCalidadController@update')->name('actualizarDocsPDF');
        route::get('/{id}/descargaPDF',     'Calidad\DocumentosCalidadController@downloadPDF')->name('verDocumento');
    });

});
