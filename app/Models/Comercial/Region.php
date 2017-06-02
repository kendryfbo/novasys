<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
	protected $table = 'regiones';

	public function clienteNacional() {

		return $this->hasMany('App\Models\Comercial\ClienteNacional');
	}
}
