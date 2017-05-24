<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

	protected $fillable = ['codigo','descripcion','familia_id','activo','iaba','nacional'];

	static function getAllActive() {

		return Marca::all()->where('activo',1);
	}

	static function getAllFromProductoTerminado() {
		$marca = Marca::whereHas('familia',function($query){
			$query->where('tipo_id','=',4);
		})->get();
	}

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

	public function producto() {

		return $this->hasMany('App\Models\Producto');
	}

	public function premezcla() {

		return $this->hasMany('App\Models\Premezcla');
	}
}
