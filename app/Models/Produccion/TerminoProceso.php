<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class TerminoProceso extends Model
{
    protected $table = 'termino_proceso';

    protected $fillable = ['prod_id','turno','producidas','rechazadas',
                           'fecha_prod','fecha_venc','maquina','operador','cod',
                           'batch','lote'];

    public function producto() {

        return $this->belongsTo('App\Models\Producto','prod_id');
    }

}
