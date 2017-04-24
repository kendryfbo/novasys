<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFamilia extends Model
{
	public function familias(){

		return $this->hasMany('App\Models\Familia');
	}
}
