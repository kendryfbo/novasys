<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ClienteNacional extends Model
{
	protected $table = 'cliente_nacional';

	protected $fillable = [
		'rut',
		'descripcion',
		'direccion',
		'fono',
		'giro',
		'fax',
		'rut_num',
		'contacto',
		'cargo',
		'email',
		'region_id',
		'provincia_id',
		'comuna_id',
		'vendedor_id',
		'activo'];


	public function region() {

		return $this->belongsTo('App\Models\Comercial\Region');
	}

	public function vendedor() {

		return $this->belongsTo('App\Models\Comercial\Vendedor');
	}

	public function sucursal() {

		return $this->hasMany('App\Models\Comercial\Sucursal','cliente_id');
	}
}
