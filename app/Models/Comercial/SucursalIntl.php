<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class SucursalIntl extends Model
{
	protected $table = 'sucursal_intl';

	protected $fillable = ['cliente_id', 'descripcion', 'direccion', 'activo'];

	public function cliente() {

		return $this->belongsTo(ClienteIntl::class,'cliente_id');
	}
}
