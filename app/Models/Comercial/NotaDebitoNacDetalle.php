<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class NotaDebitoNacDetalle extends Model
{
    protected $table = 'nota_debito_nac_detalles';
    protected $fillable = ['nd_id', 'prod_id', 'codigo', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];

}
