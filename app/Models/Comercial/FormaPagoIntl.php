<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class FormaPagoIntl extends Model
{
	protected $table = 'forma_pago_intl';

	protected $fillable = ['descripcion', 'dias', 'activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function clientes() {

		return $this->hasMany('App\Models\Comercial\ClienteIntl','fp_id');
	}

}
