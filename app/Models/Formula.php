<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{

	protected $fillable = ['producto_id','generada','generada_por','autorizado','autorizado_por','cant_batch'];

	public function detalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
	
    public function producto() {

		return $this->belongsTo('App\Models\Producto');
	}

}
