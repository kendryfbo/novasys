<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('bodega')->group( function() {

    Route::get('/test', function(){

        //return App\Models\Bodega\Pallet::getDataForBodega(5);
        dd(App\Models\Bodega\Posicion::findPositionForPallet(1,17));
        return view('bodega.bodega.test');
        $routes = Route::getRoutes();
        $routesFormatted = [];

        foreach ($routes as $route) {

            $controller = (explode('@', $route->getActionName()));
            //list($controller, $method) = explode('@', $route->getActionName());
            // $controller now is "App\Http\Controllers\FooBarController"
            $controller = preg_replace('/.*\\\/', '', $controller);
            // $controller now is "FooBarController"
            $array = [
                'name' => $route->getName(),
                'prefix' => $route->getPrefix(),
                'actionName' => $route->getActionName(),
                'controllerName' => $controller[0],
                'actionMethod' => $route->getActionMethod(),
            ];
            array_push($routesFormatted,$array);
        }
        return response($routesFormatted,200);
    });
    // Bodega
    Route::post('/ingreso/pallet', 'Bodega\BodegaController@storePalletInPosition')->name('guardarPalletEnPosicion');
    Route::get('/config',         'Bodega\BodegaController@indexConfig')->name('configBodega');
    Route::get('/',               'Bodega\BodegaController@index')->name('bodega');
    Route::get('/crear',          'Bodega\BodegaController@create')->name('crearBodega');
    Route::get('/{id}/config',    'Bodega\BodegaController@edit')->name('editarBodega');
    Route::get('/{id}/consultar', 'Bodega\BodegaController@consult')->name('consultarBodega');
    Route::post('/',              'Bodega\BodegaController@store')->name('guardarBodega');
    Route::get('/ingreso/pallet', 'Bodega\BodegaController@entry')->name('ingresoPallet');
    Route::get('/{bodega}/stock/pt', 'Bodega\BodegaController@showStockPT')->name('verStockBodegaPT');
    Route::get('/{bodega}/stock',    'Bodega\BodegaController@stock')->name('verStockBodegas');

    // Resourse Posiciones
    Route::post('/posicion/moverPallet', 'Bodega\PosicionController@changePositionPallet')->name('cambiarPosicionPallet');
    // Resource Pallets
    Route::prefix('pallet')->group(function(){

        //Route::get('/', 'Bodega\PalletController@test');

        Route::get('/',                   'Bodega\PalletController@index')->name('palletPorIngresar');
        Route::get('/{pallet}/pdf',       'Bodega\PalletController@pdfPalletProd')->name('etiquetaPalletProduccion');
        Route::post('/findPosition',      'Bodega\PalletController@position')->name('position'); // TEST
        Route::get('/MateriaPrima/crear', 'Bodega\PalletController@createPalletMP')->name('crearPalletMP');
        Route::post('/MateriaPrima',      'Bodega\PalletController@storePalletMP')->name('guardarPalletMP');
        Route::get('/materiaPrima',       'Bodega\PalletController@indexPalletMateriaPrima')->name('PalletMP');
        Route::get('/{pallet}',           'Bodega\PalletController@showPalletProduccion')->name('verPalletProduccion');

        // this should be declared in API controller
        Route::post('/data',       'Bodega\PalletController@apiData')->name('palletData');

    });

    // Resource Orden Egreso
    Route::prefix('ordenEgreso')->group(function(){

        Route::get('/',            'Bodega\OrdenEgresoController@index');
        Route::get('/pendientes',  'Bodega\OrdenEgresoController@pendingOrdenEgreso')->name('ordenEgresoPendientes');
        Route::post('/consultar',  'Bodega\OrdenEgresoController@consultExistence')->name('ordenEgresoConsultarExistencia');
        Route::post('/existencia', 'Bodega\OrdenEgresoController@checkExistence')->name('ordenEgresoVerificarExistencia');
        Route::post('/generar',    'Bodega\OrdenEgresoController@store')->name('generarOrdenEgreso');
        Route::get('/{numero}',    'Bodega\OrdenEgresoController@show')->name('verOrdenEgreso');

    });

    // Resource Ingreso
    Route::prefix('ingreso')->group(function(){

        Route::get('/',        'Bodega\IngresoController@index')->name('ingreso');
        Route::delete('/{ingreso}', 'Bodega\IngresoController@destroy')->name('eliminarIngreso');

        //ingreso Orden Compra
        Route::get('/ordenCompra/crear', 'Bodega\IngresoController@createIngFromOC')->name('crearIngOC');
        Route::post('/OrdenCompra',      'Bodega\IngresoController@storeIngFromOC')->name('guardarIngOC');
        //ingreso Manual Materia Prima
        Route::get('/Manual/MP/crear', 'Bodega\IngresoController@createIngManualMP')->name('crearIngManualMP');
        Route::post('/Manual/MP',      'Bodega\IngresoController@storeIngManualMP')->name('guardarIngManualMP');
        //ingreso Manual Premezcla
        Route::get('/Manual/PM/crear', 'Bodega\IngresoController@createIngManualPM')->name('crearIngManualPM');
        Route::post('/Manual/PM',      'Bodega\IngresoController@storeIngManualPM')->name('guardarIngManualPM');


    });

    Route::get('/creacionPalletProduccion',  'Bodega\PalletController@createPalletProduccion')->name('crearPalletProduccion');
    Route::post('/creacionPalletProduccion', 'Bodega\PalletController@storePalletProduccion')->name('guardarPalletProduccion');
    //Route::get('/ingresoManual',             'Bodega\PalletController@create')->name('crearPallet');

    // this should be declared in API controller
    Route::get('/getOpciones/{condicion}',  'Bodega\CondPosController@getOpcionesFromTipo')->name('getopcionesDeCondicion');
    Route::get('/getCondicion/{posicion}',  'Bodega\CondPosController@getCondicionOfPos')->name('getCondicionDePosicion');
    Route::post('/posicion/condicion',      'Bodega\CondPosController@store')->name('guardarCondicion');
    Route::post('/posicion/status',         'Bodega\PosicionController@storeStatus')->name('guardarStatusPosicion');
    Route::post('/posicion/pallet',         'Bodega\PosicionController@getPalletFromPosition')->name('obtenerPalletDePosicion');

});

 ?>
