<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premezcla extends Model
{

	protected $fillable= ['codigo','descripcion','familia_id','marca_id','sabor_id','unidad_med', 'activo'];

	static function getAllActive() {

		return Premezcla::all()->where('activo',1);
	}

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

	public function marca() {

		return $this->belongsTo('App\Models\Marca');
	}

	public function sabor() {

		return $this->belongsTo('App\Models\Sabor');
	}
}