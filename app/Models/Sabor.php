<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sabor extends Model
{
	protected $table = 'sabores';
    protected $fillable = ['descripcion','descrip_ing','activo'];

	static function getAllActive() {

		return self::where('activo',1)->get();
	}

	public function producto() {

		return $this->hasMany('App\Models\Producto');
	}

	public function premezcla() {

		return $this->hasMany('App\Models\Premezcla');
	}
}
