<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premezcla extends Model
{
	protected $fillable= ['codigo','descripcion','familia_id','marca_id','sabor_id','formato_id', 'activo'];

	static function getAllActive() {

		return Premezcla::where('activo',1)->get();
	}

	/*
	|
	| Relationships
	|
	*/
	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

	public function marca() {

		return $this->belongsTo('App\Models\Marca');
	}

	public function sabor() {

		return $this->belongsTo('App\Models\Sabor');
	}
	public function formato() {

		return $this->belongsTo('App\Models\Formato');
	}
}
