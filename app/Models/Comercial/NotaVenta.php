<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use DB;
class NotaVenta extends Model
{
	protected $fillable = ['numero',
							'cv_id',
							'cliente_id',
							'cond_pago',
							'version',
							'vendedor_id',
							'despacho',
							'aut_comer',
							'aut_contab',
							'sub_total',
							'descuento',
							'neto',
							'iva',
							'iaba',
							'total',
							'peso_neto',
							'peso_bruto',
							'volumen',
							'user_id',
							'fecha_emision',
							'fecha_venc'];

	protected $events = [
		'created' => \App\Events\NewNotaVentaEvent::class,
	];

	public function detalle() {

		return $this->hasMany('App\Models\Comercial\NotaVentaDetalle','nv_id');
	}

	public function cliente() {

		return $this->belongsTo('App\Models\Comercial\ClienteNacional');
	}

	public function centroVenta() {

		return $this->belongsTo('App\Models\Comercial\CentroVenta','cv_id');
	}

	/* Ejemplo para Sobre escribir metodo create
	public static function create(array $attributes = []) {

		DB::transaction(function () use ($attributes) {

			$model = static::query()->create($attributes);

			foreach ($attributes->items as $items) {

			}

		}, 5);

    	return $model;
	}
	*/
}
