<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class FacturaNacional extends Model
{
    protected $table = 'factura_nacional';

    protected $fillable = ['numero','cv_id', 'cv_rut', 'centro_venta' ,'cliente_id', 'cliente_rut','cliente',
                           'despacho', 'cond_pago', 'observacion', 'vendedor_id', 'vendedor', 'sub_total','descuento',
                           'neto','iva','iaba','total','peso_neto','peso_bruto','volumen', 'pagado',
                           'cancelado', 'user_id','fecha_emision','fecha_venc'];

    protected $events = [
    	'created' => \App\Events\CreateFacturaNacionalEvent::class,
    ];


    public function detalle() {

        return $this->belongsTo('App\Models\Comercial\FacturaNacionalDetalle');
    }
}
