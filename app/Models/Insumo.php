<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Insumo extends Model
{

	protected $fillable = ['codigo', 'descripcion', 'familia_id', 'unidad_med', 'stock_min', 'stock_max', 'activo'];

	static function getAllActive() {

		return self::all()->where('activo',1);
	}

	static function tipoID() {

		return 1; // tipo de famila Materia Prima
	}

	static function getArrayOfAllActiveWithLastPrice() {

		return DB::select('SELECT i.id,i.codigo,i.descripcion, ocd.tipo_id,IFNULL(ocd.precio,0) as precio FROM insumos as i left join orden_compra_detalles as ocd on i.id=ocd.item_id AND ocd.tipo_id=1
AND ocd.id=(SELECT MAX(id) FROM orden_compra_detalles as subocd where subocd.item_id=ocd.item_id) WHERE i.activo=1');


	}

	public function familia() {

		return $this->belongsTo('App\Models\Familia');
	}

	public function formulaDetalle() {

		return $this->hasMany('App\Models\FormulaDetalle');
	}
	public function OrdenCompraDetalle() {

		return $this->hasMany('App\Models\Adquisicion\OrdenCompraDetalle','item_id');
	}

}
