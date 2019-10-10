<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;


class Sucursal extends Model
{
	protected $table = 'sucursales';

	protected $fillable = ['cliente_id', 'vendedor_id', 'descripcion', 'direccion', 'activo'];

	public function clientesNacionales() {

		return $this->belongsTo('App\Models\Comercial\ClienteNacional','cliente_id');
	}
}
