<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ListaPrecio extends Model
{
	protected $fillable = ['descripcion','activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function listaPrecioDetalle() {

		return $this->hasMany('App\Models\Comercial\ListaPrecioDetalle','lista_id');
	}
}
