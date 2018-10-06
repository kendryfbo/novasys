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
    const BOD_MEZCLADO_ID = 6; // Id de bodega Mezclado virtual en tabla bodega.

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

    // Guardar pallet en la posicion
    static function storePalletInPosition($posicionID,$palletID) {

        DB::transaction( function() use($posicionID,$palletID) {

            $posicion = Posicion::find($posicionID);

            if ($posicion->pallet_id) {

                dd('ERROR - POSICION OCUPADA');
            }
            $pallet = Pallet::find($palletID);
            $statusPosicion = PosicionStatus::ocupadoID();

            // asignar pallet a posicion
            $posicion->pallet_id = $pallet->id;
            $posicion->status_id = $statusPosicion;
            $posicion->save();
            // status almacenado
            $pallet->almacenado = 1;
            $pallet->save();
        },5);
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
    static function blockPosition($posicionID) {

        $posicion = Posicion::blockPosition($posicionID);

        return $posicion;
    }
    static function unBlockPosition($posicionID) {

        $posicion = Posicion::unBlockPosition($posicionID);

        return $posicion;
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

    static function getExistTotalPR($productoId,$bodegaId = NULL) {

        $tipoProd = TipoFamilia::getPremezclaID();
        if ($bodegaId) {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=".$tipoProd."
            AND item_id=". $productoId . " AND pallet_id
            IN (SELECT pallet_id FROM posicion WHERE bodega_id=" . $bodegaId . " AND status_id=3)
            GROUP BY item_id";

        } else {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=".$tipoProd."
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

    static function getExistTotalRP($productoId,$bodegaId = NULL) {

        $tipoProd = TipoFamilia::getReprocesoID();
        if ($bodegaId) {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=".$tipoProd."
            AND item_id=". $productoId . " AND pallet_id
            IN (SELECT pallet_id FROM posicion WHERE bodega_id=" . $bodegaId . " AND status_id=3)
            GROUP BY item_id";

        } else {

            $query = "SELECT SUM(cantidad) AS cantidad FROM pallet_detalle
            WHERE tipo_id=".$tipoProd."
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

    static function getStockOfMPFromBodega($bodegaId = NULL) {

        $tipo = Insumo::tipoID();

        $results = [];
        $query = "SELECT insumos.id,pallet_detalle.tipo_id,insumos.codigo,insumos.descripcion,insumos.unidad_med, sum(pallet_detalle.cantidad) AS existencia
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

    static function getStockFromBodega(array $datos) {

        // datos de la busqueda
        $bodegaID = isset($datos['bodegaID']) ? $datos['bodegaID'] : null;
        $tipoID = isset($datos['tipoID']) ? $datos['tipoID'] : null;
        $familiaID = isset($datos['familiaID']) ? $datos['familiaID'] : null;
        $marcaID = isset($datos['marcaID']) ? $datos['marcaID'] : null;
        $formatoID = isset($datos['formatoID']) ? $datos['formatoID'] : null;
        $saborID = isset($datos['saborID']) ? $datos['saborID'] : null;


        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $query = "SELECT
                    bod.id bod_id,
                    bod.descripcion bod_descripcion,
                    CONCAT(pos.bloque ,'-',pos.columna,'-',pos.estante) pos,
                    pal.numero pallet_num,
                    CASE
                        WHEN pdet.tipo_id=4 THEN (SELECT id FROM productos WHERE productos.id=pdet.item_id)
                        WHEN pdet.tipo_id=5 THEN (SELECT id FROM premezclas WHERE premezclas.id=pdet.item_id)
                        WHEN pdet.tipo_id=1 THEN (SELECT id FROM insumos WHERE insumos.id=pdet.item_id)
                        WHEN pdet.tipo_id=2 THEN (SELECT id FROM reprocesos WHERE reprocesos.id=pdet.item_id)
                    END AS id,
                    CASE
                        WHEN pdet.tipo_id=4 THEN (SELECT codigo FROM productos WHERE productos.id=pdet.item_id)
                        WHEN pdet.tipo_id=5 THEN (SELECT codigo FROM premezclas WHERE premezclas.id=pdet.item_id)
                        WHEN pdet.tipo_id=1 THEN (SELECT codigo FROM insumos WHERE insumos.id=pdet.item_id)
                        WHEN pdet.tipo_id=2 THEN (SELECT codigo FROM reprocesos WHERE reprocesos.id=pdet.item_id)
                    END AS codigo,
                    CASE
                        WHEN pdet.tipo_id=4 THEN (SELECT descripcion FROM productos WHERE productos.id=pdet.item_id)
                        WHEN pdet.tipo_id=5 THEN (SELECT descripcion FROM premezclas WHERE premezclas.id=pdet.item_id)
                        WHEN pdet.tipo_id=1 THEN (SELECT descripcion FROM insumos WHERE insumos.id=pdet.item_id)
                        WHEN pdet.tipo_id=2 THEN (SELECT descripcion FROM reprocesos WHERE reprocesos.id=pdet.item_id)
                    END AS descripcion,
                    SUM(pdet.cantidad) as cantidad,
                    pdet.fecha_ing,
                    pdet.fecha_venc,
                    (TIMESTAMPDIFF(MONTH,pdet.fecha_ing,pdet.fecha_venc) - TIMESTAMPDIFF(MONTH,pdet.fecha_ing,CURDATE())) as vida_util,
                    CASE
                        WHEN pdet.tipo_id=4 THEN (SELECT marca_id FROM productos WHERE productos.id=pdet.item_id)
                        WHEN pdet.tipo_id=5 THEN (SELECT marca_id FROM premezclas WHERE premezclas.id=pdet.item_id)
                        WHEN pdet.tipo_id=1 THEN (0)
                        WHEN pdet.tipo_id=2 THEN (SELECT marca_id FROM reprocesos WHERE reprocesos.id=pdet.item_id)
                    END AS marca_id,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT marcas.descripcion FROM marcas,productos WHERE productos.id=pdet.item_id AND productos.marca_id=marcas.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT marcas.descripcion FROM marcas,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.marca_id=marcas.id)
                    	WHEN pdet.tipo_id=1 THEN ('NO POSEE')
                    	WHEN pdet.tipo_id=2 THEN (SELECT marcas.descripcion FROM marcas,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.marca_id=marcas.id)
                    END AS marca_descripcion,
                    CASE
                      WHEN pdet.tipo_id=4 THEN (SELECT familia_id FROM marcas,productos WHERE productos.id=pdet.item_id AND productos.marca_id=marcas.id)
                      WHEN pdet.tipo_id=5 THEN (SELECT familia_id FROM premezclas WHERE premezclas.id=pdet.item_id)
                      WHEN pdet.tipo_id=1 THEN (SELECT familia_id FROM insumos WHERE insumos.id=pdet.item_id)
                      WHEN pdet.tipo_id=2 THEN (SELECT familia_id FROM reprocesos WHERE reprocesos.id=pdet.item_id)
                    END AS familia_id,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT familias.descripcion FROM familias,marcas,productos WHERE productos.id=pdet.item_id AND productos.marca_id=marcas.id AND marcas.familia_id=familias.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT familias.descripcion FROM familias,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.familia_id=familias.id)
                    	WHEN pdet.tipo_id=1 THEN (SELECT familias.descripcion FROM familias,insumos WHERE insumos.id=pdet.item_id AND insumos.familia_id=familias.id)
                    	WHEN pdet.tipo_id=2 THEN (SELECT familias.descripcion FROM familias,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.familia_id=familias.id)
                    END AS familia_descripcion,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT formatos.id FROM formatos,productos WHERE productos.id=pdet.item_id AND productos.formato_id=formatos.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT formatos.id FROM formatos,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.formato_id=formatos.id)
                    	WHEN pdet.tipo_id=1 THEN (null)
                    	WHEN pdet.tipo_id=2 THEN (SELECT formatos.id FROM formatos,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.formato_id=formatos.id)
                    END AS formato_id,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT formatos.descripcion FROM formatos,productos WHERE productos.id=pdet.item_id AND productos.formato_id=formatos.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT formatos.descripcion FROM formatos,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.formato_id=formatos.id)
                    	WHEN pdet.tipo_id=1 THEN (null)
                    	WHEN pdet.tipo_id=2 THEN (SELECT formatos.descripcion FROM formatos,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.formato_id=formatos.id)
                    END AS formato_descripcion,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT sabores.id FROM sabores,productos WHERE productos.id=pdet.item_id AND productos.sabor_id=sabores.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT sabores.id FROM sabores,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.sabor_id=sabores.id)
                    	WHEN pdet.tipo_id=1 THEN (null)
                    	WHEN pdet.tipo_id=2 THEN (SELECT sabores.id FROM sabores,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.sabor_id=sabores.id)
                    END AS sabor_id,
                    CASE
                    	WHEN pdet.tipo_id=4 THEN (SELECT sabores.descripcion FROM sabores,productos WHERE productos.id=pdet.item_id AND productos.sabor_id=sabores.id)
                    	WHEN pdet.tipo_id=5 THEN (SELECT sabores.descripcion FROM sabores,premezclas WHERE premezclas.id=pdet.item_id AND premezclas.sabor_id=sabores.id)
                    	WHEN pdet.tipo_id=1 THEN (null)
                    	WHEN pdet.tipo_id=2 THEN (SELECT sabores.descripcion FROM sabores,reprocesos WHERE reprocesos.id=pdet.item_id AND reprocesos.sabor_id=sabores.id)
                    END AS sabor_descripcion
                    FROM bodegas bod, posicion pos, pallets pal, pallet_detalle pdet
                    WHERE bod.id=pos.bodega_id AND pal.id=pos.pallet_id AND pal.id=pdet.pallet_id";


        if ($bodegaID) {

            $query = $query . " AND bod.id=".$bodegaID;
        }
        if ($tipoID) {

            $query = $query . " AND pdet.tipo_id=".$tipoID;
        }
        // se agrega HAVING a la query
        $query = $query . " GROUP BY bod_id,pos,tipo_id,item_id HAVING true ";

        if ($familiaID) {
            $query = $query . " AND familia_id=".$familiaID;
        }
        if ($marcaID) {
            $query = $query . " AND marca_id=".$marcaID;
        }
        if ($formatoID) {
            $query = $query . " AND formato_id=".$formatoID;
        }
        if ($saborID) {
            $query = $query . " AND sabor_id=".$saborID;
        }
        $query = $query . " ORDER BY pos.bloque,pos.columna,pos.estante,marca_descripcion,formato_descripcion,sabor_descripcion,fecha_ing ";
        //dd($query);
        $results = DB::select(DB::raw($query));

        return $results;
    }
    static function getStockByTipoFromBodega($bodegaID = null, $tipoID = null) {

        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $results = [];
        $query = "SELECT
                    CASE
                    WHEN pallet_detalle.tipo_id='$PT' THEN (select id from productos where productos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$PR' THEN (select id from premezclas where premezclas.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$MP' THEN (select id from insumos where insumos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$RP' THEN (select id from reprocesos where reprocesos.id=pallet_detalle.item_id)
                    END AS id,
                    CASE
                    WHEN pallet_detalle.tipo_id='$PT' THEN (select codigo from productos where productos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$PR' THEN (select codigo from premezclas where premezclas.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$MP' THEN (select codigo from insumos where insumos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$RP' THEN (select codigo from reprocesos where reprocesos.id=pallet_detalle.item_id)
                    END AS codigo,
                    CASE
                    WHEN pallet_detalle.tipo_id='$PT' THEN (select descripcion from productos where productos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$PR' THEN (select descripcion from premezclas where premezclas.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$MP' THEN (select descripcion from insumos where insumos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$RP' THEN (select descripcion from reprocesos where reprocesos.id=pallet_detalle.item_id)
                    END AS descripcion,
                    CASE
                    WHEN pallet_detalle.tipo_id='$PT' THEN (select 'uni')
                    WHEN pallet_detalle.tipo_id='$PR' THEN (select 'uni')
                    WHEN pallet_detalle.tipo_id='$MP' THEN (select unidad_med from insumos where insumos.id=pallet_detalle.item_id)
                    WHEN pallet_detalle.tipo_id='$RP' THEN (select 'kg')
                    END AS unidad_med,
                    sum(pallet_detalle.cantidad) AS existencia
                    FROM pallet_detalle ";

        if ($bodegaID) {

            $query = $query . "WHERE pallet_detalle.pallet_id IN (SELECT pallet_id FROM posicion WHERE bodega_id =".$bodegaID.") ";
        } else {
            $query = $query . "WHERE pallet_detalle.pallet_id IN (SELECT pallet_id FROM posicion) ";
        }
        if ($tipoID) {

            $query = $query . "AND pallet_detalle.tipo_id=".$tipoID." ";
        }

        $query = $query . " GROUP BY pallet_detalle.item_id,pallet_detalle.tipo_id ORDER BY descripcion ASC";
        $results = DB::select(DB::raw($query));
        return $results;

    }

    static function getStockInBodega($bodegaID=null,$tipoID=null,$itemID = null) {

        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $query = "SELECT id.item_id AS id, id.tipo_id AS tipo_id,
                    CASE
                    WHEN tipo_id='$PT' THEN (select codigo from productos where productos.id=id.item_id)
                    WHEN tipo_id='$PR' THEN (select codigo from premezclas where premezclas.id=id.item_id)
                    WHEN tipo_id='$MP' THEN (select codigo from insumos where insumos.id=id.item_id)
                    WHEN tipo_id='$RP' THEN (select codigo from reprocesos where reprocesos.id=id.item_id)
                    END AS codigo,
                    CASE
                    WHEN tipo_id='$PT' THEN (select descripcion from productos where productos.id=id.item_id)
                    WHEN tipo_id='$PR' THEN (select descripcion from premezclas where premezclas.id=id.item_id)
                    WHEN tipo_id='$MP' THEN (select descripcion from insumos where insumos.id=id.item_id)
                    WHEN tipo_id='$RP' THEN (select descripcion from reprocesos where reprocesos.id=id.item_id)
                    END AS descripcion,
                    CASE
                    WHEN tipo_id='$PT' THEN (select 'uni')
                    WHEN tipo_id='$PR' THEN (select 'uni')
                    WHEN tipo_id='$MP' THEN (select unidad_med from insumos where insumos.id=id.item_id)
                    WHEN tipo_id='$RP' THEN (select 'kg')
                    END AS unidad_med,
                    sum(id.cantidad) AS existencia
                    FROM pallet_detalle as id";

        if ($bodegaID) {
            $query = $query . " WHERE id.pallet_id in (SELECT pallet_id FROM posicion where bodega_id='$bodegaID')";
        } else {
            $query = $query . " WHERE id.pallet_id in (SELECT pallet_id FROM posicion)";
        }

        if ($tipoID) {
            $query = $query . " AND id.tipo_id='$tipoID'";
            if ($itemID) {
                $query = $query . " AND id.item_id='$itemID'";
            }
        }

        $query = $query . " GROUP BY id.tipo_id,id.item_id";

        $results = DB::select(DB::raw($query));


        return $results;
    }

    static function getStockTotalPR() {

        $PR = TipoFamilia::getPremezclaID();
        $tablePremezcla = (new Premezcla)->getTable();
        $tablePalletDetalle = (new PalletDetalle)->getTable();
        $tableIngresoDetalle = (new IngresoDetalle)->getTable();

        $query = 'SELECT pre.id,pre.codigo,pre.descripcion,
            IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=pre.id AND pd.tipo_id='.$PR.'),0) AS cant_bod,
            IFNULL((SELECT sum(por_procesar) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=pre.id AND id.tipo_id='.$PR.'),0) AS cant_ing,
            IFNULL(((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=pre.id AND pd.tipo_id='.$PR.') +
            (SELECT sum(por_procesar) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=pre.id AND id.tipo_id='.$PR.')),0) AS total
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
            IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=mp.id AND pd.tipo_id='.$MP.'),0) AS cant_bod,
            IFNULL((SELECT sum(por_procesar) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=mp.id AND id.tipo_id='.$MP.'),0) AS cant_ing,
            IFNULL((IFNULL((SELECT sum(cantidad) FROM '.$tablePalletDetalle.' pd WHERE pd.item_id=mp.id AND pd.tipo_id='.$MP.'),0) +
            IFNULL((SELECT sum(por_procesar) FROM '.$tableIngresoDetalle.' id WHERE id.item_id=mp.id AND id.tipo_id='.$MP.'),0)),0) AS total,
            0 AS requerida,0 AS faltante
            FROM '.$tableInsumo.' mp';
        $results = DB::select(DB::raw($query));
        return $results;
    }

    static function getStockTotal($tipoReporte = NULL,$bodegaID = null,$tipo = NULL, $familia = NULL,$marca = NULL, $formato = NULL, $sabor = NULL) {

        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $results = [];
        // consultas de producto terminado
        $codProdTermQuery = "WHEN tipo_id=".$PT." THEN (select codigo from productos where productos.id=id.item_id)";
        $descripProdTermQuery = "WHEN tipo_id=".$PT." THEN (select descripcion from productos where productos.id=id.item_id)";
        $familiaIdProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT fam.id as familia_id FROM productos as prod JOIN marcas AS marc ON prod.marca_id=marc.id JOIN familias AS fam ON marc.familia_id=fam.id where prod.id=id.item_id)";
        $familiaDescripProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT fam.descripcion as familia FROM productos as prod JOIN marcas AS marc ON prod.marca_id=marc.id JOIN familias AS fam ON marc.familia_id=fam.id where prod.id=id.item_id)";
        $saborIdProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT sabores.id as sabor_id FROM productos as prod,sabores where prod.id=id.item_id AND prod.sabor_id=sabores.id)";
        $saborDescripProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT sabores.descripcion as sabor FROM productos as prod, sabores where prod.id=id.item_id AND prod.sabor_id=sabores.id)";
        $formatoIdProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT formatos.id as formato_id FROM productos as prod,formatos where prod.id=id.item_id AND prod.formato_id=formatos.id)";
        $formatoDescripProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT formatos.descripcion as formato FROM productos as prod, formatos where prod.id=id.item_id AND prod.formato_id=formatos.id)";
        $marcaIdProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT marcas.id as marca_id FROM productos as prod,marcas where prod.id=id.item_id AND prod.marca_id=marcas.id)";
        $marcaDescripProdTermQuery = "WHEN tipo_id=".$PT." THEN (SELECT marcas.descripcion as marca FROM productos as prod, marcas where prod.id=id.item_id AND prod.marca_id=marcas.id)";

        // consultas de Premezcla
        $codPremezclaQuery = "WHEN tipo_id=".$PR." THEN (select codigo from premezclas where premezclas.id=id.item_id)";
        $descripPremezclaQuery = "WHEN tipo_id=".$PR." THEN (select descripcion from premezclas where premezclas.id=id.item_id)";
        $familiaIdPremezclaQuery = "WHEN tipo_id=".$PR." THEN (select familia_id from premezclas where premezclas.id=id.item_id)";
        $familiaDescripPremezclaQuery = "WHEN tipo_id=".$PR." THEN (select (select descripcion from familias where premezclas.familia_id=familias.id) as familia from premezclas where premezclas.id=id.item_id)";
        $saborIdPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT sabores.id as sabor_id FROM premezclas,sabores where premezclas.id=id.item_id AND premezclas.sabor_id=sabores.id)";
        $saborDescripPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT sabores.descripcion as sabor FROM premezclas, sabores where premezclas.id=id.item_id AND premezclas.sabor_id=sabores.id)";
        $formatoIdPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT formatos.id as formato_id FROM premezclas,formatos where premezclas.id=id.item_id AND premezclas.formato_id=formatos.id)";
        $formatoDescripPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT formatos.descripcion as formato FROM premezclas, formatos where premezclas.id=id.item_id AND premezclas.formato_id=formatos.id)";
        $marcaIdPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT marcas.id as marca_id FROM premezclas,marcas where premezclas.id=id.item_id AND premezclas.marca_id=marcas.id)";
        $marcaDescripPremezclaQuery = "WHEN tipo_id=".$PR." THEN (SELECT marcas.descripcion as marca FROM premezclas, marcas where premezclas.id=id.item_id AND premezclas.marca_id=marcas.id)";

        // consultas de Insumos
        $codInsumoQuery = "WHEN tipo_id=".$MP." THEN (select codigo from insumos where insumos.id=id.item_id)";
        $descripInsumoQuery = "WHEN tipo_id=".$MP." THEN (select descripcion from insumos where insumos.id=id.item_id)";
        $familiaIdInsumoQuery = "WHEN tipo_id=".$MP." THEN (select familia_id from insumos where insumos.id=id.item_id)";
        $familiaDescripInsumoQuery = "WHEN tipo_id=".$MP." THEN (select (select descripcion from familias where insumos.familia_id=familias.id) as familia from insumos where insumos.id=id.item_id)";
        $saborIdInsumoQuery = " "; // no posee sabor.
        $saborDescripInsumoQuery = " "; // no posee sabor.
        $formatoIdInsumoQuery = " "; // no posee formato.
        $formatoDescripInsumoQuery = " "; // no posee formato.
        $marcaIdInsumoQuery = " "; // no posee marca.
        $marcaDescripInsumoQuery = " "; // no posee marca.

        // consultas de Reproceso
        $codReprocesoQuery = "WHEN tipo_id=".$RP." THEN (select codigo from reprocesos where reprocesos.id=id.item_id)";
        $descripReprocesoQuery = "WHEN tipo_id=".$RP." THEN (select descripcion from reprocesos where reprocesos.id=id.item_id)";
        $familiaIdReprocesoQuery = "WHEN tipo_id=".$RP." THEN (select familia_id from reprocesos where reprocesos.id=id.item_id)";
        $familiaDescripReprocesoQuery = "WHEN tipo_id=".$RP." THEN (select (select descripcion from familias where reprocesos.familia_id=familias.id) as familia from reprocesos where reprocesos.id=id.item_id)";
        $saborIdReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT sabores.id as sabor_id FROM reprocesos,sabores where reprocesos.id=id.item_id AND reprocesos.sabor_id=sabores.id)";
        $saborDescripReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT sabores.descripcion as sabor FROM reprocesos, sabores where reprocesos.id=id.item_id AND reprocesos.sabor_id=sabores.id)";
        $formatoIdReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT formatos.id as formato_id FROM reprocesos,formatos where reprocesos.id=id.item_id AND reprocesos.formato_id=formatos.id)";
        $formatoDescripReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT formatos.descripcion as formato FROM reprocesos, formatos where reprocesos.id=id.item_id AND reprocesos.formato_id=formatos.id)";
        $marcaIdReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT marcas.id as marca_id FROM reprocesos,marcas where reprocesos.id=id.item_id AND reprocesos.marca_id=marcas.id)";
        $marcaDescripReprocesoQuery = "WHEN tipo_id=".$RP." THEN (SELECT marcas.descripcion as marca FROM reprocesos, marcas where reprocesos.id=id.item_id AND reprocesos.marca_id=marcas.id)";

        // agrupacion de consultas
        $codigoQuery = " CASE "
        .$codProdTermQuery
        .$codPremezclaQuery
        .$codInsumoQuery
        .$codReprocesoQuery
        ." END AS codigo,";

        $descripcionQuery = " CASE "
        .$descripProdTermQuery
        .$descripPremezclaQuery
        .$descripInsumoQuery
        .$descripReprocesoQuery
        ."END AS descripcion,";

        $FamiliaIdQuery = " (CASE "
        .$familiaIdProdTermQuery
        .$familiaIdPremezclaQuery
        .$familiaIdInsumoQuery
        .$familiaIdReprocesoQuery
        ."END) AS familia_id,";

        $FamiliaDescripQuery = " (CASE "
        .$familiaDescripProdTermQuery
        .$familiaDescripPremezclaQuery
        .$familiaDescripInsumoQuery
        .$familiaDescripReprocesoQuery
        ."END) AS familia,";

        $saborIdQuery = " (CASE "
        .$saborIdProdTermQuery
        .$saborIdPremezclaQuery
        .$saborIdInsumoQuery
        .$saborIdReprocesoQuery
        ."END) AS sabor_id,";

        $saborDescripQuery = " (CASE "
        .$saborDescripProdTermQuery
        .$saborDescripPremezclaQuery
        .$saborDescripInsumoQuery
        .$saborDescripReprocesoQuery
        ."END) AS sabor,";

        $formatoIdQuery = " (CASE "
        .$formatoIdProdTermQuery
        .$formatoIdPremezclaQuery
        .$formatoIdInsumoQuery
        .$formatoIdReprocesoQuery
        ."END) AS formato_id,";

        $formatoDescripQuery = " (CASE "
        .$formatoDescripProdTermQuery
        .$formatoDescripPremezclaQuery
        .$formatoDescripInsumoQuery
        .$formatoDescripReprocesoQuery
        ."END) AS formato,";

        $marcaIdQuery = " (CASE "
        .$marcaIdProdTermQuery
        .$marcaIdPremezclaQuery
        .$marcaIdInsumoQuery
        .$marcaIdReprocesoQuery
        ."END) AS marca_id,";

        $marcaDescripQuery = " (CASE "
        .$marcaDescripProdTermQuery
        .$marcaDescripPremezclaQuery
        .$marcaDescripInsumoQuery
        .$marcaDescripReprocesoQuery
        ."END) AS marca,";


        // Reporte de productos Ingresados
        if ($tipoReporte == 1) {
            $query = "SELECT "
            .$codigoQuery
            .$descripcionQuery
            .$FamiliaIdQuery
            .$FamiliaDescripQuery
            .$saborIdQuery
            .$saborDescripQuery
            .$formatoIdQuery
            .$formatoDescripQuery
            .$marcaIdQuery
            .$marcaDescripQuery
            ." IFNULL(SUM(por_procesar),0) AS cantidad FROM ingreso_detalle AS id";

            $query = $query . " WHERE 1";

        // Reporte de productos En bodega
        } else if ($tipoReporte == 2) {

            $query = "SELECT "
            .$codigoQuery
            .$descripcionQuery
            .$FamiliaIdQuery
            .$FamiliaDescripQuery
            .$saborIdQuery
            .$saborDescripQuery
            .$formatoIdQuery
            .$formatoDescripQuery
            .$marcaIdQuery
            .$marcaDescripQuery
            ." IFNULL(SUM(cantidad),0) AS cantidad,
            pos.bodega_id
             FROM pallet_detalle AS id, posicion as pos";

            $query = $query . " WHERE pos.pallet_id=id.pallet_id";

            if ($bodegaID) {
                $query = $query . " AND bodega_id=" . $bodegaID;
            }
        // Total de productos en ingreso y en bodega
        } else {
            $query = "SELECT "
            .$codigoQuery
            .$descripcionQuery
            .$FamiliaIdQuery
            .$FamiliaDescripQuery
            .$saborIdQuery
            .$saborDescripQuery
            .$formatoIdQuery
            .$formatoDescripQuery
            .$marcaIdQuery
            .$marcaDescripQuery
            ." (IFNULL((SELECT SUM(por_procesar) from ingreso_detalle where ingreso_detalle.tipo_id=id.tipo_id and ingreso_detalle.item_id=id.item_id),0)+IFNULL((SELECT SUM(cantidad) from pallet_detalle where pallet_detalle.tipo_id=id.tipo_id and pallet_detalle.item_id=id.item_id),0)) as cantidad
                        from ingreso_detalle as id
                        join pallet_detalle  as pd using (tipo_id,tipo_id)";

            $query = $query . " WHERE 1";
        }

        if ($tipo) {
            $query = $query . " AND tipo_id=" . $tipo;
        }

        // AGRUPADO POR item_id y tipo_id
        $query = $query . " GROUP BY id.item_id,id.tipo_id";

        // agregado HAVING para filtros
        $query = $query . " HAVING 1";

        // FILTROS
        if ($familia) {
            $query = $query . " AND familia_id=" . $familia;
        }
        if ($marca) {
            $query = $query . " AND marca_id=" . $marca;
        }
        if ($formato) {
            $query = $query . " AND formato_id=" . $formato;
        }
        if ($sabor) {
            $query = $query . " AND sabor_id=" . $sabor;
        }

        // Ordenado por cantidad de mayor a menor
        $query = $query . " ORDER BY descripcion ASC";

        $results = DB::select(DB::raw($query));

        //dd($results);
        return $results;
    }

    static function descount($bodegaID,$tipoID,$itemID,$cantidad) {

        $posiciones = [];

        while ($cantidad > 0) {

            $restar=0;

            $posicion = Posicion::getPositionThatContainItem($bodegaID,$tipoID,$itemID);
            if (!$posicion) {

                dd('Error al Descontar Producto o Insumo - No existencia');
            }

            $posID = $posicion['id'];
            $existencia = $posicion['existencia'];

            if ($cantidad > $existencia) {

                $restarDePosicion = $existencia;
            } else {
                $restarDePosicion = $cantidad;
            }

            $cantidad = $cantidad - $restarDePosicion;

            while ($restarDePosicion > 0) {

                $posicion = Posicion::getPositionOfItem($posID,$tipoID,$itemID);
                $existenciaDetalle = $posicion->existencia;
                $detalleLote = $posicion->detalle_lote;
                $palletNum = $posicion->pallet_num;
                unset($posicion->detalle_lote);
                unset($posicion->pallet_num);

                if ($restarDePosicion > $existenciaDetalle) {

                    $restarDetalle = $existenciaDetalle;
                } else {
                    $restarDetalle = $restarDePosicion;
                }

                $posicion->subtract($posicion->detalle_id,$restarDetalle);
                $posicion->detalle_lote = $detalleLote;
                $posicion->pallet_num = $palletNum;
                $posicion->cantidad = $restarDetalle;
                array_push($posiciones,$posicion);

                $restarDePosicion = $restarDePosicion - $restarDetalle;
            }

        };

        return $posiciones;
    }

    static function getBodPremixID() {

        return self::BOD_PREMIX_ID;
    }

    static function getBodMezcladoID() {

        return self::BOD_MEZCLADO_ID;
    }


    static function getCodigoByTipoQuery($tableName) {

        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $query ="CASE
                    WHEN tipo_id='$PT' THEN (select codigo from productos where productos.id=".$tableName.".item_id)
                    WHEN tipo_id='$PR' THEN (select codigo from premezclas where premezclas.id=".$tableName.".item_id)
                    WHEN tipo_id='$MP' THEN (select codigo from insumos where insumos.id=".$tableName.".item_id)
                    WHEN tipo_id='$RP' THEN (select codigo from reprocesos where reprocesos.id=".$tableName.".item_id)
                END AS codigo";
        return $query;
    }

    static function getDescripcionByTipoQuery($tableName) {

        $PT = TipoFamilia::getProdTermID();
        $PR = TipoFamilia::getPremezclaID();
        $MP = TipoFamilia::getInsumoID();
        $RP = TipoFamilia::getReprocesoID();

        $query ="CASE
                    WHEN tipo_id='$PT' THEN (select descripcion from productos where productos.id=".$tableName.".item_id)
                    WHEN tipo_id='$PR' THEN (select descripcion from premezclas where premezclas.id=".$tableName.".item_id)
                    WHEN tipo_id='$MP' THEN (select descripcion from insumos where insumos.id=".$tableName.".item_id)
                    WHEN tipo_id='$RP' THEN (select descripcion from reprocesos where reprocesos.id=".$tableName.".item_id)
                END AS descripcion";

        return $query;
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
