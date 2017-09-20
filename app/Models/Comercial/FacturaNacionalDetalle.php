<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class FacturaNacionalDetalle extends Model
{
    protected $fillable = ['fact_id', 'item', 'producto_id', 'descripcion', 'cantidad', 'precio', 'descuento', 'sub_total'];

    protected $table = 'fact_nac_detalles';

    /* Relations */
    public function facturaNacinal() {

        return $this->belongsTo('App\Models\Comercial\FacturaNacional','fact_id');
    }

    public function producto() {

        return $this->belongsTo('App\Models\Producto','producto_id');
    }
}
