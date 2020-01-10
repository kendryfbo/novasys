<?php

namespace App\Models\Comercial;

use DB;
use App\Models\Config\StatusDocumento;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial\FacturaNacionalDetalle;
use App\Models\Comercial\NotaDebitoNac;
use App\Models\Finanzas\PagoNacional;


class FacturaNacional extends Model
{
    protected $table = 'factura_nacional';

    protected $fillable = ['numero', 'numero_nv', 'cv_id', 'cv_rut', 'centro_venta' ,'cliente_id', 'cliente_rut','cliente',
                           'direccion', 'despacho', 'cond_pago', 'observacion', 'vendedor_id', 'vendedor', 'sub_total','descuento',
                           'neto','iva','iaba','total','peso_neto','peso_bruto','volumen', 'pagado', 'dolarDia',
                           'cancelada', 'user_id','fecha_emision','fecha_venc', 'deuda'];


    protected $dates = ['fecha_venc'];

    protected $events = [
    	'created' => \App\Events\CreateFacturaNacionalEvent::class,
    ];

    /* Public Functions */

	public function updatePago() {

        if ($this->deuda <= 0) {

					$this->cancelada = 1;

				} else {

					$this->cancelada = 0;
				}
    }

	public function reverseUpdatePago() {

		if ($this->deuda >= 0) {
			$this->cancelada = 0;
		}
	}

    /*
    |
    |	Relationships
    |
    */

    public function pagos() {

        return $this->hasMany(PagoNacional::class,'factura_id');
    }

    public function notasDebito() {

        return $this->hasMany(NotaDebitoNac::class,'factura_id');

    }

    public function detalles() {

        return $this->hasMany('App\Models\Comercial\FacturaNacionalDetalle','fact_id');
    }

    public function centroVenta() {

        return $this->belongsTo('App\Models\Comercial\CentroVenta','cv_id');
    }

    public function clienteNac() {

        return $this->belongsTo('App\Models\Comercial\ClienteNacional','cliente_id');
    }

    public function notaDeb() {

        return $this->belongsTo('App\Models\Comercial\NotaDebitoNac','factura_id');

    }


    public function vendedor() {

        return $this->belongsTo('App\Models\Comercial\Vendedor');
    }
}
