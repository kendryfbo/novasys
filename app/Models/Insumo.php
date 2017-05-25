<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{

	protected $fillable = ['codigo', 'descripcion', 'familia_id', 'unidad_med', 'stock_min', 'stock_max', 'activo'];

	static function getAllActive() {

		return Insumo::all()->where('activo',1);
	}

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

	public function formulaDetalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}

}
