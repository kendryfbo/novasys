<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

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
