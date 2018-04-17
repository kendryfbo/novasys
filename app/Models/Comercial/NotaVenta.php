<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use DB;
class NotaVenta extends Model
{
	protected $fillable = ['numero','cv_id','cliente_id','cond_pago','version','vendedor_id','orden_compra','despacho',
							'aut_comer','aut_contab','sub_total','descuento','neto','iva','iaba','total',
							'peso_neto','peso_bruto','volumen','user_id','fecha_emision','fecha_despacho'];

	// static Methods
	static function unauthorized() {

		return self::whereNull('aut_comer')->get();
	}

	static function getAllAuthorizedNotProcessed() {

        return self::where('aut_comer',1)
                        ->where('aut_contab',1)
                        ->where('status',1)
                        ->get();
    }


	// public Methods
	public function authorizeComer() {

		$this->aut_comer = 1;
		$this->save();
	}

	public function unauthorizeComer() {

		$this->aut_comer = 0;
		$this->status = 0;
		$this->save();
	}

	public function authorizeContab() {

		$this->aut_contab = 1;
		$this->save();
	}

	public function unauthorizeContab() {

		$this->aut_contab = 0;
		$this->save();
	}

	public function isAuthorized() {

        if ($this->aut_comer && $this->aut_contab) {
            return true;
        }
        return false;
    }

	public function setTitleAttribute($value) {

		dd($value);
	}

	//relations Methods
	/* duplicado para retro compatibilidad */
	public function detalle() {

		return $this->hasMany('App\Models\Comercial\NotaVentaDetalle','nv_id');
	}
	public function detalles() {

		return $this->hasMany('App\Models\Comercial\NotaVentaDetalle','nv_id');
	}

	public function cliente() {

		return $this->belongsTo('App\Models\Comercial\ClienteNacional');
	}

	public function centroVenta() {

		return $this->belongsTo('App\Models\Comercial\CentroVenta','cv_id');
	}

	public function formaPago() {

		return $this->belongsTo('App\Models\Comercial\FormaPagoNac','cond_pago');
	}

	public function vendedor() {

		return $this->belongsTo('App\Models\Comercial\Vendedor');
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
