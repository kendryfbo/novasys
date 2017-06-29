<?php

namespace App\Repositories\Comercial\FacturaNacional;


interface FacturaNacionalRepositoryInterface {

	// Crear Factura Manual
	public function register($request);

	// Crear Factura a partir de Nota de Venta 
	public function registerFromNV($request);

}
