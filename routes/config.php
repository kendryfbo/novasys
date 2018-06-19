<?php

route::prefix('config')->group(function() {

	Route::prefix('perfiles')->group(function() {

		Route::get('/', 		   'Config\PerfilAccesoController@index')->name('perfilAcceso');
		Route::get('/crear', 	   'Config\PerfilAccesoController@create')->name('crearPerfilAcceso');
		Route::post('/crear', 	   'Config\PerfilAccesoController@store')->name('guardarPerfilAcceso');
		Route::get('/{id}', 	   'Config\PerfilAccesoController@show')->name('verPerfilAcceso');
		Route::get('/{id}/editar', 'Config\PerfilAccesoController@edit')->name('editarPerfilAcceso');
		Route::put('/{id}/editar', 'Config\PerfilAccesoController@update')->name('actualizarPerfilAcceso');
		Route::post('/{id}', 	   'Config\PerfilAccesoController@destroy')->name('eliminarPerfilAcceso');
	});

	Route::prefix('accesos')->group(function() {

		Route::get('/importar',   'Config\PerfilAccesoController@registerAccess')->name('importarAccesos');
	});
});
