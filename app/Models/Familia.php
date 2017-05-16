<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{

	protected $fillable = ['codigo','descripcion','tipo_id','activo'];

	static function getAllActive() {

		return Familia::all()->where('activo',1);
	}

	public function tipo() {

		return $this->belongsTo('App\Models\TipoFamilia');
	}

	public function marca() {

		return $this->hasMany('App\Models\Marca');
	}

	public function premezcla() {

		return $this->hasMany('App\Models\Premezcla');
	}

}
