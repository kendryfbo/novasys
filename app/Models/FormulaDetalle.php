<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaDetalle extends Model
{

	protected $fillable = ['formula_id','insumo_cod','insumo_descrip','nivel_id','cantxuni','cantxcaja','cantxbatch','batch'];

	public function formula() {

		return $this->belongsTo('App\Models\Formula');
	}
}
