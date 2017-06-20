<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class CentroVenta extends Model
{

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function notaVenta() {

		return $this->hasMany('App\Models\Comercial\NotaVenta','cv_id');
	}
}