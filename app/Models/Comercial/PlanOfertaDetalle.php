<?php

namespace App\Models\Comercial;

use App\Models\Producto;
use App\Models\Comercial\ClienteNacional;
use Illuminate\Database\Eloquent\Model;

class PlanOfertaDetalle extends Model
{
    protected $fillable = ['plan_id', 'producto_id', 'cliente_id', 'nombre_cliente', 'nombre_producto', 'descuento'];
    protected $table = 'plan_oferta_detalles';


    /*
    |
    |  Relationships
    |
    */


    public function producto() {

      return $this->belongsTo('App\Models\Producto');
    }

    public function cliente() {

      return $this->belongsTo('App\Models\Comercial\ClienteNacional');
    }
}
