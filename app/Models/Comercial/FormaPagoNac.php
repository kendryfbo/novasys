<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class FormaPagoNac extends Model
{

	protected $fillable = ['descripcion'];

	protected $table = 'forma_pago_nac';

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function cliente() {

		return $this->hasMany('App\Models\Comercial\ClienteNacional','fp_id');
	}
}
