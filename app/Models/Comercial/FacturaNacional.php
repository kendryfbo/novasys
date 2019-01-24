<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class FacturaNacional extends Model
{
    protected $table = 'factura_nacional';

    protected $fillable = ['numero', 'numero_nv', 'cv_id', 'cv_rut', 'centro_venta' ,'cliente_id', 'cliente_rut','cliente',
                           'direccion', 'despacho', 'cond_pago', 'observacion', 'vendedor_id', 'vendedor', 'sub_total','descuento',
                           'neto','iva','iaba','total','peso_neto','peso_bruto','volumen', 'pagado',
                           'cancelada', 'user_id','fecha_emision','fecha_venc', 'deuda'];

    protected $events = [
    	'created' => \App\Events\CreateFacturaNacionalEvent::class,
    ];

    public function updatePago() {

        if ($this->deuda <= 0) {
            $this->cancelada = 1;
        }
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

    public function vendedor() {

        return $this->belongsTo('App\Models\Comercial\Vendedor');
    }
}
