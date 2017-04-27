<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

	protected $fillable = ['codigo','descripcion','familia_id','activo','ila','nacional'];

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}
}
