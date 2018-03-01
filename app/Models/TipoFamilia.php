<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamilia extends Model
{
	// Constancia
	const INSUMO_ID = 1; // correspondiente a materia prima tabla tipo_familia
	const PT_ID = 4;	 // correspondiente a Producto Terminado tabla tipo_familia

	// static methods
	static function getAllActive() {

		return TipoFamilia::All()->where('activo',1);
	}

	static function getMP() {

		return self::find(1);
	}

	static function insumo() {

		return self::find(self::INSUMO_ID);
	}
	static function productoTerminado() {

		return self::find(self::PT_ID);
	}

	// Relationships
	public function familias(){

		return $this->hasMany('App\Models\Familia');
	}



}
