<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoNacDetalle extends Model
{
    protected $table = 'nota_credito_nac_detalle';
    protected $fillable = ['nc_id', 'prod_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];

    public function notaCredito() {

        return $this->belongsTo('App\Models\Comercial\NotaCreditoNac','nc_id');
    }

}
