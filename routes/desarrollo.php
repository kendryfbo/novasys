<?php

// GRUPO de Rutas de Modulo Desarrollo
Route::middleware('auth')->prefix('desarrollo')->group( function(){

	// Pantalla Principal Modulo Desarrollo
    Route::get('/', 'DesarrolloController@main')->name('desarrollo');

    Route::get('/pdf', 'DesarrolloController@pdf')->name('testPDF');
    Route::get('/htmlPdf', 'DesarrolloController@htmlPdf')->name('testPDF2');

	// GRUPO de Rutas de Desarrollo/Familias
	Route::group(['prefix' => 'familias'], function(){

		Route::get('/',					'FamiliaController@index')->name('familias');
		Route::get('create', 			'FamiliaController@create')->name('crearFamilia');
		Route::post('/', 				'FamiliaController@store')->name('guardarFamilia');
		Route::get('/{familia}/edit', 	'FamiliaController@edit')->name('editarFamilia');
		Route::post('update/{familia}', 'FamiliaController@update')->name('actualizarFamilia');
		Route::post('delete/{familia}', 'FamiliaController@destroy')->name('eliminarFamilia');

	});

	// GRUPO de Rutas de Desarrollo/Marcas
	Route::group(['prefix' => 'marcas'], function(){

		Route::get('/',					'MarcaController@index')->name('marcas');
		Route::get('crear', 			'MarcaController@create')->name('crearMarca');
		Route::post('/', 				'MarcaController@store')->name('guardarMarca');
		Route::get('/{marca}/edit', 	'MarcaController@edit')->name('editarMarca');
		Route::post('update/{marca}', 	'MarcaController@update')->name('actualizarMarca');
		Route::post('delete/{marca}', 	'MarcaController@destroy')->name('eliminarMarca');

	});

	// GRUPO de Rutas de Desarrollo/Sabores
	Route::group(['prefix' => 'sabores'], function(){

		Route::get('/',					'SaborController@index')->name('sabores');
		Route::get('crear', 			'SaborController@create')->name('crearSabor');
		Route::post('/', 				'SaborController@store')->name('guardarSabor');
		Route::get('/{sabor}/edit', 	'SaborController@edit')->name('editarSabor');
		Route::post('update/{sabor}', 	'SaborController@update')->name('actualizarSabor');
		Route::post('delete/{sabor}', 	'SaborController@destroy')->name('eliminarSabor');

	});

	// GRUPO de Rutas de Desarrollo/Formatos
	Route::group(['prefix' => 'formatos'], function(){

		Route::get('/',					'FormatoController@index')->name('formatos');
		Route::get('crear', 			'FormatoController@create')->name('crearFormato');
		Route::post('/', 				'FormatoController@store')->name('guardarFormato');
		Route::get('/{formato}/edit', 	'FormatoController@edit')->name('editarFormato');
		Route::post('update/{formato}', 'FormatoController@update')->name('actualizarFormato');
		Route::post('delete/{formato}', 'FormatoController@destroy')->name('eliminarFormato');

	});

	// GRUPO de Rutas de Desarrollo/Productos
	Route::group(['prefix' => 'productos'], function(){

		Route::get('/',					 'ProductoController@index')->name('productos');
		Route::get('crear', 			 'ProductoController@create')->name('crearProducto');
		Route::post('/', 				 'ProductoController@store')->name('guardarProducto');
		Route::get('/{producto}/edit', 	 'ProductoController@edit')->name('editarProducto');
		Route::get('/{codigo}', 	     'ProductoController@show')->name('verProducto');
		Route::get('/{id}/excel', 	     'ProductoController@downloadExcel')->name('descargarCostoProductoExcel');
		Route::post('update/{producto}', 'ProductoController@update')->name('actualizarProducto');
		Route::post('delete/{producto}', 'ProductoController@destroy')->name('eliminarProducto');

	});

	// GRUPO de Rutas de Desarrollo/Premezcla
	Route::group(['prefix' => 'premezclas'], function(){

		Route::get('/',					  'PremezclaController@index')->name('premezclas');
		Route::get('crear', 			  'PremezclaController@create')->name('crearPremezcla');
		Route::post('/', 				  'PremezclaController@store')->name('guardarPremezcla');
		Route::get('/{premezcla}/edit',   'PremezclaController@edit')->name('editarPremezcla');
		Route::post('update/{premezcla}', 'PremezclaController@update')->name('actualizarPremezcla');
		Route::post('delete/{premezcla}', 'PremezclaController@destroy')->name('eliminarPremezcla');

	});

	// GRUPO de Rutas de Desarrollo/Reproceso
	Route::group(['prefix' => 'reprocesos'], function(){

		Route::get('/',					  'ReprocesoController@index')->name('reprocesos');
		Route::get('crear', 			  'ReprocesoController@create')->name('crearReproceso');
		Route::post('/', 				  'ReprocesoController@store')->name('guardarReproceso');
		Route::get('/{reproceso}/edit',   'ReprocesoController@edit')->name('editarReproceso');
		Route::post('update/{reproceso}', 'ReprocesoController@update')->name('actualizarReproceso');
		Route::post('delete/{reproceso}', 'ReprocesoController@destroy')->name('eliminarReproceso');

	});

	// GRUPO de Rutas de Desarrollo/Insumo
	Route::group(['prefix' => 'insumos'], function(){

		Route::get('/',				   'InsumoController@index')->name('insumos');
		Route::get('crear', 		   'InsumoController@create')->name('crearInsumo');
		Route::post('/', 			   'InsumoController@store')->name('guardarInsumo');
		Route::get('/{insumo}/edit',   'InsumoController@edit')->name('editarInsumo');
		Route::post('update/{insumo}', 'InsumoController@update')->name('actualizarInsumo');
		Route::post('delete/{insumo}', 'InsumoController@destroy')->name('eliminarInsumo');

	});
	// GRUPO de Rutas de Desarrollo/Formulas
	Route::group(['prefix' => 'formulas'], function(){

		Route::get('/',					      'FormulaController@index')->name('formulas');
		Route::get('crear', 			      'FormulaController@create')->name('crearFormula');
		Route::post('/', 				      'FormulaController@store')->name('guardarFormula');
		Route::get('/{id}/edit', 	          'FormulaController@edit')->name('editarFormula');
        Route::get('/autorizacion',            'FormulaController@autorization')->name('autorizacionFormula');
		Route::get('/{id}', 	              'FormulaController@show')->name('verFormula');
		Route::put('/{id}', 	              'FormulaController@update')->name('actualizarFormula');
		Route::get('/autorizacion/{formula}',  'FormulaController@showForAuth')->name('verAutFormula');
		Route::post('/autorizar/{formula}',	  'FormulaController@autorizar')->name('autorizarFormula');
		Route::post('/desautorizar/{formula}', 'FormulaController@desautorizar')->name('desautorizarFormula');
		Route::post('/delete/{formula}',       'FormulaController@destroy')->name('eliminarFormula');
		// GRUPO de Rutas de Desarrollo/Formulas
		Route::group(['prefix' => 'detalle'], function(){

			Route::get('/',					'FormulaDetalleController@index')->name('detalleFormula');
			Route::get('crear', 			'FormulaDetalleController@create')->name('crearDetalleFormula');
			Route::post('/', 				'FormulaDetalleController@store')->name('guardarDetalleFormula');
			Route::get('/{detalle}/edit', 	'FormulaDetalleController@edit')->name('editarDetalleFormula');
			Route::post('update/{detalle}', 'FormulaDetalleController@update')->name('actualizarDetalleFormula');
			Route::post('delete/{detalle}', 'FormulaDetalleController@destroy')->name('eliminarDetalleFormula');

		});
	});

    // Grupo de Rutas Productos Mantencion
    Route::prefix('prodMantencion')->group(function() {

        Route::get('/',          'ProdMantencionController@index')->name('prodMantencion');
        Route::get('/crear',     'ProdMantencionController@create')->name('crearProdMantencion');
        Route::post('/',         'ProdMantencionController@store')->name('guardarProdMantencion');
        Route::get('/{id}/edit', 'ProdMantencionController@edit')->name('editarProdMantencion');
        Route::put('/{id}',      'ProdMantencionController@update')->name('actualizarProdMantencion');
        Route::post('/{id}',     'ProdMantencionController@destroy')->name('eliminarProdMantencion');
    });
});
