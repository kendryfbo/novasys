<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamilia extends Model
{

	static function getAllActive() {

		return TipoFamilia::All()->where('activo',1);
	}

	public function familias(){

		return $this->hasMany('App\Models\Familia');
	}
}
