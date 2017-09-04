<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class ClienteIntl extends Model
{
	protected $table = 'cliente_intl';
	protected $fillable = ['descripcion', 'direccion', 'pais', 'zona', 'idioma',
	'fono', 'giro', 'fax', 'contacto', 'cargo', 'email', 'fp_id', 'credito', 'activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function formaPago() {

		return $this->belongsTo('App\Models\Comercial\FormaPagoIntl','fp_id');
	}

	public function sucursales() {

		return $this->hasMany(SucursalIntl::class,'cliente_id');
	}
}
