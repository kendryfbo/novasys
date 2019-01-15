<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ClienteIntl extends Model
{
	protected $table = 'cliente_intl';
	protected $fillable = ['descripcion', 'direccion', 'pais_id', 'zona', 'idioma',
	'fono', 'giro', 'fax', 'contacto', 'cargo', 'email', 'fp_id', 'credito', 'activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	/*
	|
	| Relationships
	|
	*/

	public function formaPago() {

		return $this->belongsTo('App\Models\Comercial\FormaPagoIntl','fp_id');
	}

	public function pais() {

		return $this->belongsTo('App\Models\Comercial\Pais','pais_id');
	}

	public function sucursales() {

		return $this->hasMany(SucursalIntl::class,'cliente_id');
	}

	public function proformas() {

		return $this->hasMany(Proforma::class,'cliente_id');
	}

	public function facturasIntls() {

		return $this->hasMany('App\Models\Comercial\FacturaIntl','cliente_id');
	}
}
