<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaVentaDetalle extends Model
{
	protected $fillable = ['nv_id', 'item', 'producto_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];

	public function notaVenta() {

		return $this->belongsTo('App\Models\Comercial\NotaVenta','nv_id');
	}

	public function producto() {

		return $this->belongsTo('App\Models\Producto','producto_id');
	}
}
