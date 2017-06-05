<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ListaPrecio extends Model
{
	protected $fillable = ['descripcion','activo'];

	public function listaPrecioDetalle() {

		return $this->hasMany('App\Models\Comercial\ListaPrecioDetalle','lista_id');
	}
}
