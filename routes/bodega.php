<?php


// GRUPO de Rutas de Modulo Operaciones-Bodega
Route::prefix('bodega')->group( function() {

    Route::get('/updatePalletLote', function(){

        $palletDetalle = App\Models\Bodega\PalletDetalle::with('ingreso.detalles')->where('ing_tipo_id',2)->get();
        //dd($palletDetalle);
        $i=0;
        foreach ($palletDetalle as $detalle) {
            $i++;
            dump($i);
            $lote = $detalle->ingreso->detalles[0]->lote;
            dump($lote);
            $detalle->lote = $lote;
            $detalle->save();
        }
        dd('done');
    });

    Route::get('/grupoprem', function(){
        $nivelPremix = 2;
        $formulas = App\Models\Formula::with('producto.marca','producto.sabor','producto.formato')
                                            ->where('autorizado',1)
                                            ->where('premezcla_id',0)->get();
        $formulas->load(['detalle' => function ($query) use ($nivelPremix){
            $query->where('nivel_id',$nivelPremix);
        }]);

        $premezclaNum = 0;

        foreach ($formulas as &$formulaUno) {

            if($formulaUno->premezcla_num) {
                continue;
            }
            $premezclaNum++;

            $formulaUno->premezcla_num = $premezclaNum;

            foreach ($formulas as &$formulaDos) {

                if($formulaDos->premezcla_num) {
                    continue;
                }

                $detalleUno = $formulaUno->detalle;
                $detalleDos = $formulaDos->detalle;

                $formulasIguales = true;

                if (count($detalleUno) == count($detalleDos)) {

                    foreach ($detalleUno as $uno) {
                        $detIguales = false;
                        foreach ($detalleDos as $dos) {

                            $detIguales = false;
                            if ($uno->insumo_id == $dos->insumo_id) {
                                $detIguales = true;
                                break;
                            }
                        }

                        if (!$detIguales) {
                            $formulasIguales = false;
                            break;
                        }
                    }
                } else {

                    $formulasIguales = false;
                }

                //dump("formulaUno ".$formulaUno->id,"formulaDos ".$formulaDos->id);
                if ($formulasIguales) {
                    $formulaDos->premezcla_num = $formulaUno->premezcla_num;
                    //dump('son iguales');
                } else {

                    //dump('no son iguales');
                }
            }
        }

        $groupByPrem = $formulas->groupBy('premezcla_num');
        $premezclas = [];
        $relaciones = [];
        $i=59;
        foreach ($groupByPrem as $premezcla) {
            $i++;
            $prem = $premezcla[0];
            $premId = $i;
            $premCod = 'PRE'.$prem->producto->marca_id.$prem->producto->sabor_id.$prem->producto->formato_id;
            $premDescrip = 'PREMEZCLA '.$prem->producto->marca->descripcion.' '.$prem->producto->sabor->descripcion.' '.$prem->producto->formato->peso_uni.'g';
            $premezclas[$i]['id'] = $premId;
            $premezclas[$i]['codigo'] = $premCod;
            $premezclas[$i]['descripcion'] = $premDescrip;
            $premezclas[$i]['familia_id'] = 1;
            $premezclas[$i]['marca_id'] = $prem->producto->marca_id;
            $premezclas[$i]['sabor_id'] = $prem->producto->sabor_id;
            $premezclas[$i]['formato_id'] = $prem->producto->formato_id;
            //dump('#'.$i.' - GRUPO PREMEZCLA -');
                foreach ($premezcla as $item) {
                    $relacion = [];
                    $relacion['id'] = $item->producto->id;
                    $relacion['prem_id'] = $premId;
                    $relacion['descripcion'] = $item->producto->descripcion;
                    array_push($relaciones,$relacion);
                    //dump('-id: '.$item->producto->id.' -Descrip:'.$item->producto->descripcion);
                }
        }
        return Excel::create('RELACION PREMEZCLA', function($excel) use ($premezclas,$relaciones) {

            $excel->sheet('Premezcla', function($sheet) use ($premezclas) {
                            $sheet->loadView('documents.excel.premezclas')
                                ->with('premezclas', $premezclas);
                            })
                    ->sheet('Relacion', function($sheet) use ($relaciones) {
                                $sheet->loadView('documents.excel.grupoPremezclas')
                                        ->with('relaciones', $relaciones);
                                })
                    ->download('xlsx');
        });
        dd('FIN');

    });

    Route::get('/test', function(){

        dd(App\Models\Bodega\Pallet::getDataForBodega(1408));
        dd(App\Models\Bodega\Posicion::findPositionForPallet(1,944));
        // password hash
        //dd(Hash::make('ca01'));

        // LISTA DE RUTAS
        $routes = Route::getRoutes();
        $routesFormatted = [];

        foreach ($routes as $route) {

            $controller = (explode('@', $route->getActionName()));
            //list($controller, $method) = explode('@', $route->getActionName());
            // $controller now is "App\Http\Controllers\FooBarController"
            $controller = preg_replace('/.*\\\/', '', $controller);

            $prefix = trim($route->getPrefix());
            $prefix = explode('/',$prefix);
            $prefix = array_filter($prefix, function($value) { return $value !== ''; });
            $prefix = array_slice($prefix,0);
            if (!$prefix) {
                $prefix = 'main';
            } else {
                $prefix = $prefix[0];
            }
            if (!$route->getName()) {

            } else {

                $array = [
                    'nombre' => $route->getName(),
                    'modulo' => $prefix,
                    'controller' => $controller[0],
                    'action' => $route->getActionMethod(),
                ];
                array_push($routesFormatted,$array);
            }
        }
        //dd($routesFormatted[0]['name']);
        //return response($routesFormatted,200);

        return Excel::create('Routes', function($excel) use ($routesFormatted) {
            $excel->sheet('New sheet', function($sheet) use ($routesFormatted) {
                $sheet->loadView('documents.excel.routes')
                        ->with('routes', $routesFormatted);
                            })->download('xlsx');
                        });

    });
    // Bodega
    Route::post('/ingreso/pallet',   'Bodega\BodegaController@storePalletInPosition')->name('guardarPalletEnPosicion');
    Route::get('/config',            'Bodega\BodegaController@indexConfig')->name('configBodega');
    Route::get('/',                  'Bodega\BodegaController@index')->name('bodega');
    Route::get('/crear',             'Bodega\BodegaController@create')->name('crearBodega');
    Route::get('/{id}/config',       'Bodega\BodegaController@edit')->name('editarBodega');
    Route::get('/{id}/consultar',    'Bodega\BodegaController@consult')->name('consultarBodega');
    Route::post('/',                 'Bodega\BodegaController@store')->name('guardarBodega');
    Route::get('/ingreso/pallet',    'Bodega\BodegaController@entry')->name('ingresoPallet');
    //Route::get('/{bodega}/stock/pt', 'Bodega\BodegaController@showStockPT')->name('verStockBodegaPT');
    Route::get('/{bodega}/stock',    'Bodega\BodegaController@stock')->name('verStockBodegas');

    // Reportes
    Route::get('/reporte',          'Bodega\BodegaReportController@indexBodegaReport')->name('reporteBodega');
    Route::post('/reporte',         'Bodega\BodegaReportController@indexBodegaReport')->name('reporteBodega');
    Route::post('/reporte/excel',   'Bodega\BodegaReportController@downloadBodegaReportExcel')->name('reporteBodegaExcel');
    Route::get('/stock',            'Bodega\BodegaReportController@indexStockReport')->name('reporteStockTotal');
    Route::post('/stock',           'Bodega\BodegaReportController@indexStockReport')->name('reporteStockTotal');
    Route::post('/stock/reporte',   'Bodega\BodegaReportController@donwloadStockTotalReportExcel')->name('descargarReportStockTotalExcel');

    // Resourse Posiciones
    Route::post('/posicion/moverPallet', 'Bodega\PosicionController@changePositionPallet')->name('cambiarPosicionPallet');
    // Resource Pallets
    Route::prefix('pallet')->group(function(){

        //Route::get('/', 'Bodega\PalletController@test');

        Route::get('/',                    'Bodega\PalletController@index')->name('palletPorIngresar');
        Route::get('/{pallet}/pdf',        'Bodega\PalletController@pdfPalletProd')->name('etiquetaPalletProduccion');
        // Creacion de pallet Materia Prima
        Route::get('/MateriaPrima/crear',  'Bodega\PalletController@createPalletMP')->name('crearPalletMP');
        Route::post('/MateriaPrima',       'Bodega\PalletController@storePalletMP')->name('guardarPalletMP');
        Route::get('/materiaPrima',        'Bodega\PalletController@indexPalletMateriaPrima')->name('PalletMP');
        // Creacion de pallet Producto Terminado
        Route::get('/PT/crear',            'Bodega\PalletController@createPalletPT')->name('crearPalletPT');
        Route::post('/PT',                 'Bodega\PalletController@storePalletPT')->name('guardarPalletPT');
        // Creacion de pallet Materia Prima
        Route::get('/Premezcla/crear',     'Bodega\PalletController@createPalletPR')->name('crearPalletPR');
        Route::post('/Premezcla',          'Bodega\PalletController@storePalletPR')->name('guardarPalletPR');
        // Agregar Items a Pallet
        route::get('/agregarItem',         'Bodega\PalletController@addItemToPallet')->name('agregarItemPallet');
        route::post('/agregarItem',        'Bodega\PalletController@storeItemToPallet')->name('guardarItemPallet');
        // Movimiento entre pallets
        route::post('/movEntrePallets',    'Bodega\PalletController@storeMovBetweenPallet')->name('guardarMovEntrePallet');

        Route::get('/{pallet}',            'Bodega\PalletController@show')->name('verPallet');
        // this should be declared in API controller
        Route::post('/findPosition',       'Bodega\PalletController@position')->name('position'); // TEST
        Route::post('/data',               'Bodega\PalletController@apiData')->name('palletData');
        Route::post('/buscarPosConPallet', 'Bodega\PalletController@findPallet')->name('buscarPosConPallet');

    });
    // Resource Ingreso
    Route::prefix('ingreso')->group(function(){

        //ingreso Orden Compra
        Route::get('/ordenCompra',        'Bodega\IngresoController@indexPendingOC')->name('ingOC');
        Route::post('/ordenCompra/crear', 'Bodega\IngresoController@createIngOC')->name('crearIngOC');
        Route::post('/OrdenCompra',       'Bodega\IngresoController@storeIngFromOC')->name('guardarIngOC');
        //ingreso Manual Materia Prima
        Route::get('/Manual/MP/crear', 'Bodega\IngresoController@createIngManualMP')->name('crearIngManualMP');
        Route::post('/Manual/MP',      'Bodega\IngresoController@storeIngManualMP')->name('guardarIngManualMP');
        //ingreso Manual Producto Terminado
        Route::get('/Manual/PT/crear', 'Bodega\IngresoController@createIngManualPT')->name('crearIngManualPT');
        Route::post('/Manual/PT',      'Bodega\IngresoController@storeIngManualPT')->name('guardarIngManualPT');
        //ingreso Manual Premezcla
        Route::get('/Manual/PR/crear', 'Bodega\IngresoController@createIngManualPR')->name('crearIngManualPR');
        Route::post('/Manual/PR',      'Bodega\IngresoController@storeIngManualPR')->name('guardarIngManualPR');

        // Ingreso Devolucion Materia Prima
        Route::get('/Devolucion/MP/crear', 'Bodega\IngresoController@createIngDevolucionMP')->name('crearIngDevolucionMP');
        Route::post('/Devolucion/MP',      'Bodega\IngresoController@storeIngDevolucionMP')->name('guardarIngDevolucionMP');
        // Ingreso Devolucion Producto terminado
        Route::get('/Devolucion/PT/crear', 'Bodega\IngresoController@createIngDevolucionPT')->name('crearIngDevolucionPT');
        Route::post('/Devolucion/PT',      'Bodega\IngresoController@storeIngDevolucionPT')->name('guardarIngDevolucionPT');
        // Ingreso Devolucion Premezcla
        Route::get('/Devolucion/PR/crear', 'Bodega\IngresoController@createIngDevolucionPR')->name('crearIngDevolucionPR');
        Route::post('/Devolucion/PR',      'Bodega\IngresoController@storeIngDevolucionPR')->name('guardarIngDevolucionPR');

        Route::get('/',             'Bodega\IngresoController@index')->name('ingreso');
        Route::get('/{numero}',    'Bodega\IngresoController@show')->name('verIngreso');
        Route::delete('/{ingreso}', 'Bodega\IngresoController@destroy')->name('eliminarIngreso');

    });

    // Resource Egreso
    Route::prefix('egreso')->group(function(){

        // ACCESOS API
        Route::post('/existencia', 'Bodega\EgresoController@checkOrdenEgresoExist')->name('apiExistenciaEgrOrdenEgreso');

        //egreso Documento - Proforma y Nota Venta
        Route::get('/ordenEgreso',        'Bodega\EgresoController@indexPendingOrdenEgreso')->name('egresoOrdenEgreso');
        Route::post('/ordenEgreso/store', 'Bodega\EgresoController@storeEgrOrdenEgreso')->name('guardarEgrOrdenEgreso');
        Route::post('/ordenEgreso/crear', 'Bodega\EgresoController@createEgrOrdenEgreso')->name('crearEgrOrdenEgreso');
        // Egreso Manuel de Producto desde
        Route::get('/Manual/Pallet',      'Bodega\EgresoController@createEgrFromPallet')->name('crearEgrManualDePallet');
        Route::post('/Manual/Pallet',      'Bodega\EgresoController@storeEgrFromPallet')->name('guardarEgrManualDePallet');
        //Egreso Manual Materia Prima
        Route::get('/Manual/MP/crear', 'Bodega\EgresoController@createEgrManualMP')->name('crearEgrManualMP');
        //egreso Manual Producto Terminado
        Route::get('/Manual/PT/crear', 'Bodega\EgresoController@createEgrManualPT')->name('crearEgrManualPT');
        //egreso Manual Premezcla
        Route::get('/Manual/PR/crear', 'Bodega\EgresoController@createEgrManualPR')->name('crearEgrManualPR');
        //egreso Manual Reproceso
        Route::get('/Manual/RP/crear', 'Bodega\EgresoController@createEgrManualRP')->name('crearEgrManualRP');
        // Guardar Egreso Manual
        Route::post('/Manual',         'Bodega\EgresoController@storeEgrManual')->name('guardarEgrManual');

        // Egreso Traslado Materia Prima
        Route::get('/Traslado/MP/crear', 'Bodega\EgresoController@createEgrTrasladoMP')->name('crearEgrTrasladoMP');
        Route::post('/Traslado/MP',      'Bodega\EgresoController@storeEgrTrasladoMP')->name('guardarEgrTrasladoMP');
        // Egreso Traslado Producto terminado
        Route::get('/Traslado/PT/crear', 'Bodega\EgresoController@createEgrTrasladoPT')->name('crearEgrTrasladoPT');
        Route::post('/Traslado/PT',      'Bodega\EgresoController@storeEgrTrasladoPT')->name('guardarEgrTrasladoPT');
        // Egreso Traslado Premezcla
        Route::get('/Traslado/PR/crear', 'Bodega\EgresoController@createEgrTrasladoPR')->name('crearEgrTrasladoPR');
        Route::post('/Traslado/PR',      'Bodega\EgresoController@storeEgrTrasladoPR')->name('guardarEgrTrasladoPR');

        Route::get('/',             'Bodega\EgresoController@index')->name('egreso');
        Route::get('/{numero}',    'Bodega\EgresoController@show')->name('verEgreso');
        Route::delete('/{egreso}', 'Bodega\EgresoController@destroy')->name('eliminarEgreso');
        Route::get('/{numero}/descargar', 'Bodega\EgresoController@downloadPDF')->name('descargarEgresoPDF');
        Route::get('/{numero}/descargarRegInsp', 'Bodega\EgresoController@downloadRegInspEgresoPDF')->name('descargarRegInspEgresoPDF');


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
