<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
	protected $table = 'sucursales';

	protected $fillable = ['cliente_id', 'descripcion', 'direccion', 'activo'];

	public function clienteNacional() {

		return $this->belongsTo('App\Models\ClienteNacional','cliente_id');
	}
}
