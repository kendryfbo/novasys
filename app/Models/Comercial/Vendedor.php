<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
	protected $table = 'vendedores';
    protected $fillable = ['rut', 'nombre', 'iniciales','activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function clienteNacional() {

		return $this->hasMany('App\Models\Comercial\ClienteNacional');
	}
}
