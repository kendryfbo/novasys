<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamilia extends Model
{
	// static methods
	static function getAllActive() {

		return TipoFamilia::All()->where('activo',1);
	}

	static function getMP() {

		return self::find(1);
	}

	// Relationships
	public function familias(){

		return $this->hasMany('App\Models\Familia');
	}



}
