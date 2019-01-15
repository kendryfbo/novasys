<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class OrdenEgresoDetalle extends Model
{
    protected $fillable = ['orden_id', 'tipo_id', 'item_id', 'bodega', 'posicion', 'cantidad'];



    /*
    |     Relations
    */

    public function item() {

        $productoT = config('globalVars.PT');

        if ($this->tipo_id == $productoT) {

            return $this->belongsTo('App\Models\Producto','item_id');

        } else {


            return $this->belongsTo('App\Models\Producto','item_id');
        }
    }
}
