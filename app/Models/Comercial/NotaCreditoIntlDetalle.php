<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoIntlDetalle extends Model
{
    protected $table = 'nota_credito_intl_detalle';
    protected $fillable = ['nc_id', 'prod_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];
}
