<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

	protected $fillable = ['codigo','descripcion','marca_id','formato_id','sabor_id', 'vida_util', 'peso_bruto','volumen','activo'];

	static function getAllActive() {

		return Producto::all()->where('activo',1);
	}

	public function hasFormula() {

		if ($this->formula()->first()) {
			return true;
		}
		return false;

	}
	public function marca() {

		return $this->belongsTo('App\Models\Marca');
	}

	public function formato() {

		return $this->belongsTo('App\Models\Formato');
	}

	public function sabor() {

		return $this->belongsTo('App\Models\Sabor');
	}

	public function formula() {

		return $this->hasOne('App\Models\Formula');
	}

	public function listaPrecioDetalle() {

		return $this->hasMany('App\Models\Comercial\ListaPrecioDetalle');
	}

	public function guiaDespachoDetalles() {

		return $this->hasMany(GuiaDespachoDetalle::class);
	}

}
