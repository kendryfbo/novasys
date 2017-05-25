<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaDetalle extends Model
{

	protected $fillable = ['formula_id','insumo_id','descripcion','nivel_id','cantxuni','cantxcaja','cantxbatch','batch'];

	public function formula() {

		return $this->belongsTo('App\Models\Formula');
	}

	public function nivel() {

		return $this->belongsTo('App\Models\Nivel');
	}

	public function insumo() {

		return $this->belongsTo('App\Models\Insumo');
	}

}
