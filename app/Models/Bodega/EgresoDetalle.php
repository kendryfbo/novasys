<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\TipoFamilia;

class EgresoDetalle extends Model
{
        protected $table = 'egreso_detalle';
        protected $fillable = ['egr_id', 'tipo_id' , 'item_id', 'bodega', 'posicion', 'pallet_num', 'fecha_egr', 'fecha_venc', 'lote', 'cantidad'];


        // Busqueda definida especificamente para mostrar productos en orden de egreso ordenados por descripcion y cantidad.
        static function detalleOrdenEgresoPDF($egresoID){

            $tableName = EgresoDetalle::getTableName();

            $queryCodigo = Bodega::getCodigoByTipoQuery($tableName);
            $queryDescripcion = Bodega::getDescripcionByTipoQuery($tableName);

            $query ="SELECT ". $queryCodigo .",".$queryDescripcion.",";

            $query = $query."id,egr_id,tipo_id,item_id,bodega,posicion,pallet_num,fecha_egr,fecha_venc,lote,sum(cantidad) as cantidad
                                FROM egreso_detalle where egr_id=".$egresoID." GROUP BY posicion,tipo_id,item_id ORDER BY descripcion,id ASC;";
            $results = DB::select(DB::raw($query));

            if ($results) {
                return $results;
            }
            return [];
        }

        public static function getTableName() {
            return with(new static)->getTable();
        }

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
