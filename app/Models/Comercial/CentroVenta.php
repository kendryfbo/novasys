<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class CentroVenta extends Model
{

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	static function getMainCentroVenta() {

		return self::find(1); // id novafoods
	}

	public function notaVenta() {

		return $this->hasMany('App\Models\Comercial\NotaVenta','cv_id');
	}

	public function facturasNac() {

		return $this->hasMany('App\Models\Comercial\FacturaNacional','cv_id');
	}
}
