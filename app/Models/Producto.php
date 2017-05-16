<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

	protected $fillable = ['codigo','descripcion','marca_id','formato_id','sabor_id','peso_bruto','volumen','activo'];

	public function marca() {

		return $this->belongsTo('App\Models\Marca');
	}

	public function formato() {

		return $this->belongsTo('App\Models\Formato');
	}

	public function sabor() {

		return $this->belongsTo('App\Models\Sabor');
	}
}
