<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Producto;
use App\Models\TipoFamilia;
use App\Models\Bodega\IngresoTipo;
use App\Models\Bodega\IngresoDetalle;
use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    protected $table = 'ingreso_detalle';
    protected $fillable = ['ing_id','tipo_id', 'item_id', 'fecha_ing', 'fecha_venc', 'lote', 'cantidad', 'por_procesar'];

    /*
    |
    |     Relationship
    |
    */
    public function insumo() {

        return $this->belongsTo('App\Models\Insumo','item_id');
    }

    public function producto() {

        return $this->belongsTo('App\Models\Producto','item_id');
    }

    public function premezcla() {

        return $this->belongsTo('App\Models\Premezcla','item_id');
    }

    public function ingreso() {

        return $this->belongsTo('App\Models\Bodega\Ingreso','ing_id');
    }

    public function item() {

        switch ($this->tipo_id) {

            case TipoFamilia::getInsumoID();
                return $this->belongsTo('App\Models\insumo','item_id');
                break;

            case TipoFamilia::getProdTermID();
                return $this->belongsTo('App\Models\Producto','item_id');
                break;

            case TipoFamilia::getPremezclaID();
                return $this->belongsTo('App\Models\Premezcla','item_id');

            case TipoFamilia::getReprocesoID();
                return $this->belongsTo('App\Models\Reproceso','item_id');
        }
    }
}
