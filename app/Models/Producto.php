<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

	protected $fillable = ['codigo','descripcion','marca_id','formato_id','sabor_id', 'vida_util', 'peso_bruto', 'peso_neto', 'volumen','activo'];

	static function getAllActive() {

		return self::where('activo',1)->orderBy('descripcion')->get();
	}

	public function hasFormula() {

		if ($this->formula()->first()) {
			return true;
		}
		return false;

	}

	/* Relaciones con Producto */

	public function marca() {

		return $this->belongsTo('App\Models\Marca');
	}

	public function formato() {

		return $this->belongsTo('App\Models\Formato');
	}

	public function sabor() {

		return $this->belongsTo('App\Models\Sabor');
	}

	public function formula() {

		return $this->hasOne('App\Models\Formula');
	}

	public function listaPrecioDetalle() {

		return $this->hasMany('App\Models\Comercial\ListaPrecioDetalle');
	}

	public function guiaDespachoDetalles() {

		return $this->hasMany(GuiaDespachoDetalle::class);
	}

	public function facturaNacDetalles() {

		return $this->hasMany('App\Models\Comercial\FacturaNacionalDetalle','producto_id');
	}

	public function produccion() {

		return $this->hasMany('App\Models\Produccion\TerminoProceso');
	}

}
