<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{

	protected $fillable = ['producto_id','creada_por','autorizado','autorizado_por','cant_batch'];

	public function detalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
    public function producto() {

		return $this->belongsTo('App\Models\Producto');
	}

	public function nivel() {

		return $this->belongsTo('App\Models\Nivel');
	}
}
