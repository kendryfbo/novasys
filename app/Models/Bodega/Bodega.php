<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Insumo;
use App\Models\Producto;
use App\Models\Premezcla;
use App\Models\TipoFamilia;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\PalletDetalle;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    const BOD_PREMIX_ID = 5; // Id de bodega premix virtual en tabla bodega.

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
            GROUP BY item_id LIMIT 1";

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

    static function getExistTotalMP($productoId,$bodegaId = NULL) {

        if ($bodegaId) {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=1
            AND item_id=". $productoId . " AND pallet_id
            IN (SELECT pallet_id FROM posicion WHERE bodega_id=" . $bodegaId . " AND status_id=3)
            GROUP BY item_id";

        } else {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=1
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

        $query = $query . " GROUP BY pos,tipo_id,item_id";
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

    static function getStockTotalPT() {

    }
    static function getStockTotalPP() {

        $PP = config('globalVars.PP');
        $tablePremezcla = (new Premezcla)->getTable();
        $tablePalletDetalle = (new PalletDetalle)->getTable();
        $tableIngresoDetalle = (new IngresoDetalle)->getTable();

        $query = 'SELECT pre.id,pre.codigo,pre.descripcion,
            IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=pre.id AND pd.tipo_id='.$PP.'),0) as cant_bod,
            IFNULL((SELECT sum(cantidad) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=pre.id AND id.tipo_id='.$PP.'),0) as cant_ing,
            IFNULL(((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=pre.id AND pd.tipo_id='.$PP.') +
            (SELECT sum(cantidad) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=pre.id AND id.tipo_id='.$PP.')),0) as total
            FROM '.$tablePremezcla.' pre';

        $results = DB::select(DB::raw($query));
        return $results;
    }
    static function getStockTotalMP() {

        $MP = config('globalVars.MP');
        $tableInsumo = (new Insumo)->getTable();
        $tablePalletDetalle = (new PalletDetalle)->getTable();
        $tableIngresoDetalle = (new IngresoDetalle)->getTable();

        $query = 'SELECT mp.id,mp.codigo,mp.descripcion,
            IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=mp.id AND pd.tipo_id='.$MP.'),0) as cant_bod,
            IFNULL((SELECT sum(cantidad) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=mp.id AND id.tipo_id='.$MP.'),0) as cant_ing,
            IFNULL((IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=mp.id AND pd.tipo_id='.$MP.'),0) +
            IFNULL((SELECT sum(cantidad) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=mp.id AND id.tipo_id='.$MP.'),0)),0) as total,
            0 as requerida,0 as faltante
            FROM '.$tableInsumo.' mp';
        $results = DB::select(DB::raw($query));
        return $results;
    }

    static function getStockTotal($tipoReporte = NULL,$tipo = NULL) {

        $results = [];

        if ($tipoReporte == 1) {
            $query = "SELECT id.tipo_id,id.item_id,
            IFNULL((select SUM(por_procesar) from ingreso_detalle where ingreso_detalle.tipo_id=id.tipo_id and ingreso_detalle.item_id=id.item_id),0) as cantidad
            from ingreso_detalle as id";

        } else if ($tipoReporte == 2) {

            $query = "SELECT pd.tipo_id,pd.item_id,
            IFNULL((select SUM(cantidad) from pallet_detalle where pallet_detalle.tipo_id=pd.tipo_id and pallet_detalle.item_id=pd.item_id),0) as cantidad
            from pallet_detalle as pd";

        } else {

            $query = "SELECT id.tipo_id,id.item_id,
                (IFNULL((SELECT SUM(por_procesar) from ingreso_detalle where ingreso_detalle.tipo_id=id.tipo_id and ingreso_detalle.item_id=id.item_id),0)+
                IFNULL((SELECT SUM(cantidad) from pallet_detalle where pallet_detalle.tipo_id=id.tipo_id and pallet_detalle.item_id=id.item_id),0)) as cantidad
                from ingreso_detalle as id
                join pallet_detalle as pd using (tipo_id,tipo_id) ";
        }


        if ($tipo) {
            $query = $query . " WHERE tipo_id=" . $tipo;
        }

        $query = $query . " GROUP BY item_id,tipo_id";

        //dd($query);
        $results = DB::select(DB::raw($query));


        $insumo = TipoFamilia::getInsumoID();
        $prodTerm = TipoFamilia::getProdTermID();
        $premezcla = TipoFamilia::getPremezclaID();

        foreach ($results as $item) {

            if ($item->tipo_id == $insumo) {

                $item->producto = Insumo::find($item->item_id);

            } else if ($item->tipo_id == $prodTerm) {

                $item->producto = Producto::find($item->item_id);

            } else if ($item->tipo_id == $premezcla) {

                $item->producto = Premezcla::find($item->item_id);
            } else {
                dd(['ERROR' => 'ERROR en la busqueda de producto',
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id]);
            }

        }

        return $results;
    }


    static function getBodPremixID() {

        return self::BOD_PREMIX_ID;
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
