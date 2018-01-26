<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\Posicion;
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

    static function getStockFromBodega($bodegaId,$tipo = NULL) {

        $results = [];

        if(!$bodegaId) {

            return $results;
        }

        if ($tipo) {

            $query = "SELECT
                        productos.codigo,
                        productos.descripcion,
                        sum(pallet_detalle.cantidad) as cantidad
                        FROM productos,pallet_detalle
                        WHERE pallet_detalle.item_id=productos.id
                        AND pallet_detalle.tipo_id=".$tipo."
                        AND pallet_detalle.pallet_id
                        IN (SELECT pallet_id FROM posicion WHERE bodega_id=".$bodegaId.") GROUP BY pallet_detalle.item_id, productos.codigo, productos.descripcion ORDER BY cantidad DESC";
        } else {

            $query = "SELECT
                        productos.codigo,
                        productos.descripcion,
                        sum(pallet_detalle.cantidad) as cantidad
                        FROM productos,pallet_detalle
                        WHERE pallet_detalle.item_id=productos.id AND pallet_detalle.pallet_id
                        IN (SELECT pallet_id FROM posicion WHERE bodega_id=".$bodegaId.") GROUP BY pallet_detalle.item_id, productos.codigo, productos.descripcion ORDER BY cantidad DESC";
        }
        //dd($query);
        $results = DB::select(DB::raw($query));
        return $results;
    }

    // Relationships

    public function posiciones() {

        return $this->hasMany('App\Models\Bodega\Posicion','bodega_id');
    }
}
