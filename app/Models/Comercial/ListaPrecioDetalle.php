<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ListaPrecioDetalle extends Model
{
	protected $fillable = ['lista_id','producto_id','descripcion','precio'];

	public function listaPrecio() {

		return $this->belongsTo('App\Models\Comercial\ListaPrecio','lista_id');
	}

	public function producto() {

		return $this->belongsTo('App\Models\Producto');
	}
}
