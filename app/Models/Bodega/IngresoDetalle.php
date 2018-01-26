<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    protected $table = 'ingreso_detalle';
    protected $fillable = ['ing_id','tipo_id', 'item_id', 'fecha_venc', 'cantidad', 'por_almacenar'];

    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }

    public function ingreso() {

        return $this->belongsTo('App\Models\Bodega\Ingreso','ing_id');
    }
}
