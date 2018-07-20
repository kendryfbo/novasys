<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamilia extends Model
{
	// Constantes
	const INSUMO_ID = 1; // correspondiente a id de materia prima tabla tipo_familia
	const PT_ID = 4;	 // correspondiente aid de Producto Terminado tabla tipo_familia
	const PM_ID = 5;	 // correspondiente a id de Premezcla tabla tipo_familia
	const RP_ID = 2;	 // correspondiente a id de Reproceso o Pre-Proceso tabla tipo_familia
	const REPUESTO_ID = 7;	 // correspondiente a id de Repuestos tabla tipo_familia

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
	static function getInsumoID() {

		return self::INSUMO_ID;
	}
	static function getProdTermID() {

		return self::PT_ID;
	}
	static function getPremezclaID() {

		return self::PM_ID;
	}
	static function getReprocesoID() {

		return self::RP_ID;
	}
	static function getRepuestoID() {

		return self::REPUESTO_ID;
	}

	// Relationships
	public function familias(){

		return $this->hasMany('App\Models\Familia');
	}



}
