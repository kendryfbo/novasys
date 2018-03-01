<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PalletDetalle;
use App\Models\Insumo;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{

    protected $fillable = ['descripcion', 'bloque', 'columna', 'estante', 'activo'];


    /*
     *    STATIC FUNCTIONS
     */

    static function getAllActive() {

        return self::all()->where('activo',1);
    }

    static function getPositions($bodegaId) {

         $bloques = Posicion::where('bodega_id',$bodegaId)->orderBy('bloque','asc')->groupBy('bloque')->pluck('bloque');

         foreach ($bloques as $keyBloq => $bloque) {

             $estantes = Posicion::where('bodega_id',$bodegaId)->where('bloque',$bloque)->orderBy('estante','desc')->groupBy('estante')->pluck('estante');

             foreach ($estantes as $keyEstante => $estante) {

                 $posicion = Posicion::with('status')->orderBy('columna','asc')->where('bodega_id',$bodegaId)->where('bloque',$bloque)->where('estante',$estante)->get();

                 $estantes[$keyEstante] = $posicion;
             }
             $bloques[$keyBloq] = $estantes;
         };

         return $bloques;
    }

    static function createBodega($request) {

        DB::transaction(function () use ($request) {

            $bodega = Bodega::create([
                'descripcion' => $request->descripcion,
                'activo' => $request->activo
            ]);


            $bloques = $request->bloque;
            $columnas = $request->columna;
            $estantes = $request->estante;
            $medida = $request->medida;

            for ($bloque=0; $bloque < $bloques; $bloque++) {

                for ($columna=0; $columna < $columnas; $columna++) {

                    for ($estante=0; $estante < $estantes; $estante++) {

                        Posicion::create([
                            'bodega_id' => $bodega->id,
                            'bloque' => $bloque+1,
                            'columna' => $columna+1,
                            'estante' => $estante+1,
                            'medida_id' => $medida,
                            'status_id' => 2
                        ]);
                    }
                }
            }

        },5); // transaction
    }

    static function getExistTotalPT($productoId,$bodegaId = NULL) {

        if ($bodegaId) {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=4
            AND item_id=". $productoId . " AND pallet_id
            IN (SELECT pallet_id FROM posicion WHERE bodega_id=" . $bodegaId . " AND status_id=3)
            GROUP BY item_id";
            return response($query,200);
        } else {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=4
            AND item_id=". $productoId . " AND pallet_id
            IN (SELECT pallet_id FROM posicion WHERE status_id=3)
            GROUP BY item_id LIMIT 1";
        }

        $results = DB::select(DB::raw($query));

        if (!$results) {

            return 0;
        }
        return $results[0]->cantidad;
    }

    static function getStockFromBodega($bodegaId = NULL,$tipo = NULL) {

        $results = [];

        $query = "SELECT    bod.id bodega_id,
                            bod.descripcion bodega,
                            pos.id pos_id,
                            CONCAT(pos.bloque ,'-',pos.columna,'-',pos.estante) pos,
                            pm.descripcion medida,
                            ps.descripcion status_posicion,
                            p.id pallet_id,
                            p.numero pallet_numero,
                            pd.id pd_id,
                            pd.fecha_venc fecha_venc,
                            SUM(pd.cantidad) cantidad,
                            pd.tipo_id tipo_id,
                            pd.item_id item_id

                    FROM    bodegas bod,
                            posicion pos,
                            posicion_status ps,
                            pallets p,
                            pallet_medida pm,
                            pallet_detalle pd

                    WHERE   pos.bodega_id=bod.id
                        AND pos.status_id=ps.id
                        AND pos.pallet_id=p.id
                        AND p.medida_id=pm.id
                        AND pd.pallet_id=p.id
                        AND pos.pallet_id IS NOT NULL ";

        if ($bodegaId) {

            $query = $query . " AND bod.id=" . $bodegaId;
        }
        if ($tipo) {
            $query = $query . " AND pd.tipo_id=" . $tipo;
        }

        $query = $query . "GROUP BY pos,tipo_id,item_id";
        //$query = $query . "GROUP BY bod.id,bodega,pos_id,medida,status_posicion,pallet_id,pallet_numero,pd_id,fecha_Venc,pos,tipo_id,item_id";
        $results = DB::select(DB::raw($query));

        foreach ($results as $item) {

            $detalle = PalletDetalle::find($item->pd_id);
            $detalle->producto();
            $item->producto = $detalle->producto;
        }

        return $results;
    }

    static function getStockOfMPFromBodega($bodegaId = NULL) {

        $tipo = Insumo::tipoID();

        $results = [];
        $query = "SELECT insumos.id,pallet_detalle.tipo_id,insumos.codigo,insumos.descripcion,insumos.unidad_med, sum(pallet_detalle.cantidad) as existencia
                    FROM insumos,pallet_detalle
                    WHERE pallet_detalle.item_id=insumos.id
                    AND pallet_detalle.tipo_id=".$tipo."
                    AND pallet_detalle.pallet_id";


        if($bodegaId) {

            $query = $query . " IN (SELECT pallet_id FROM posicion WHERE bodega_id=".$bodegaId.")";
        } else {
            $query = $query . " IN (SELECT pallet_id FROM posicion)";
        }

         $query = $query . " GROUP BY pallet_detalle.item_id,pallet_detalle.tipo_id,insumos.id, insumos.codigo, insumos.descripcion,insumos.unidad_med ORDER BY cantidad DESC";

        $results = DB::select(DB::raw($query));
        return $results;
    }
    /*
    |
    | Public Functions
    |
    */


    // Relationships

    public function posiciones() {

        return $this->hasMany('App\Models\Bodega\Posicion','bodega_id');
    }
}
