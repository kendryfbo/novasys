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

	public function notaVenta() {

		return $this->hasMany('App\Models\Comercial\NotaVenta','cond_pago');
	}
}
