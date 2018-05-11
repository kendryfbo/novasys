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
		'fp_id',
		'lp_id',
		'canal_id',
		'region_id',
		'provincia_id',
		'comuna_id',
		'vendedor_id',
		'activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	public function region() {

		return $this->belongsTo('App\Models\Comercial\Region');
	}

	public function vendedor() {

		return $this->belongsTo('App\Models\Comercial\Vendedor');
	}

	public function sucursal() {

		return $this->hasMany('App\Models\Comercial\Sucursal','cliente_id');
	}

	public function canal() {

		return $this->belongsTo('App\Models\Comercial\Canal');
	}

	public function formaPago() {

		return $this->belongsTo('App\Models\Comercial\FormaPagoNac','fp_id');
	}

	public function listaPrecio() {

		return $this->belongsTo('App\Models\Comercial\ListaPrecio','lp_id');
	}

	public function notaVenta() {

		return $this->hasMany('App\Models\Comercial\NotaVenta');
	}

	public function facturasNac() {

		return $this->hasMany('App\Models\Comercial\FacturaNacional','cliente_id');
	}

	public function comuna() {

		return $this->belongsTo('App\Models\Comercial\Comuna','comuna_id');
	}
}
