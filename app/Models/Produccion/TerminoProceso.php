<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class TerminoProceso extends Model
{
    protected $table = 'termino_proceso';

    protected $fillable = ['prod_id','turno','producidas','rechazadas', 'total',
                           'fecha_prod','fecha_venc','maquina','operador','cod',
                           'batch','lote', 'por_procesar', 'procesado'];

    public function producto() {

        return $this->belongsTo('App\Models\Producto','prod_id');
    }

}
