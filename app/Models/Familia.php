<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{

	protected $fillable = ['codigo','descripcion','tipo'];


	static function getTipoFamilia() {

		return TipoFamilia::all()->where('activo',1);

	}

	public function Tipo() {

		return $this->belongsTo('App\Models\TipoFamilia');

	}

}
