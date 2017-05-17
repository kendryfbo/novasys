<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{

	protected $fillable = ['codigo', 'descripcion', 'familia_id', 'unidad_med', 'stock_min', 'stock_max', 'activo'];

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

}
