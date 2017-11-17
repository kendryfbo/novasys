<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    protected $table = 'ingreso_detalle';
    protected $fillable = ['ing_id','tipo_id', 'item_id', 'fecha_venc', 'cantidad', 'ingresado'];

}
