<?php

namespace App\Repositories\Comercial\NotaVenta;


interface NotaVentaRepositoryInterface {

	public function register($request);
	public function registerEdit($request,$notaVenta);

}
