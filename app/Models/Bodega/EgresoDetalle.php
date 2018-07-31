<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use App\Models\TipoFamilia;

class EgresoDetalle extends Model
{
        protected $table = 'egreso_detalle';
        protected $fillable = ['egr_id', 'tipo_id' , 'item_id', 'bodega', 'posicion', 'fecha_egr', 'fecha_venc', 'lote', 'cantidad'];

        /*
        |
        |   Relationships
        |
        */

        public function item() {

            switch ($this->tipo_id) {

                case TipoFamilia::getInsumoID();
                    return $this->belongsTo('App\Models\Insumo','item_id');
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
