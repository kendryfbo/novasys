<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\Pallet;

class Posicion extends Model
{
    const COND_TIPO_FAMILIA = 1;
    const COND_FAMILIA = 2;
    const COND_MARCA = 3;
    const COND_PRODUCTO = 4;
    const COND_INSUMO = 5;
    const COND_PREMEZCLA = 6;
    const COND_REPROCESO = 7;

    protected $table = 'posicion';
    protected $fillable = ['bodega_id', 'bloque', 'columna', 'estante', 'medida', 'status_id', 'pallet_id'];

    protected $PT;
    protected $MP;

    public function __construct(array $attributes = array()) {

        parent::__construct($attributes);

        $PT = config('globalVars.PT');
        $MP = config('globalVars.MP');
    }

    /*
     * STATIC FUNCTIONS
     */

    static function findPositionFor($productos) {

        $queryCond1 = '';
        $queryCond2 = '';
        $queryCond3 = '';
        $queryCond4 = '';

        foreach ($productos as $producto) {

            $queryCond1 = 'AND tipo_id=1 AND opcion_id=' . $producto->id .' '. $queryCond1;
            $queryCond2 = 'AND tipo_id=2 AND opcion_id=' . $producto->marca->id .' '. $queryCond2;
            $queryCond3 = 'AND tipo_id=3 AND opcion_id=' . $producto->marca->familia->id .' '. $queryCond3;
            $queryCond4 = 'AND tipo_id=4 AND opcion_id=' . $producto->marca->familia->tipo->id .' '. $queryCond4;

        }

        $query = "SELECT * FROM posicion,cond_pos WHERE posicion.id=cond_pos.posicion_id AND posicion.status_id=2 ". $queryCond1;
        $results = DB::select(DB::raw($query));

        if ($results) {

            dd($results);
        }
        $query = "SELECT * FROM posicion,cond_pos WHERE posicion.id=cond_pos.posicion_id AND posicion.status_id=2 ". $queryCond2;
        $results = DB::select(DB::raw($query));

        if ($results) {

            dd($results);
        }

        // si no cumple ninguna condicion buscar posicion sin condicion
        $query = "SELECT * FROM posicion,cond_pos WHERE posicion.id!=cond_pos.posicion_id";
        $results = DB::select(DB::raw($query));


        dd($results);
    }

    static function findPositionForPallet($bodegaId,$palletId) {

        $PT = config('globalVars.PT');
        $MP = config('globalVars.MP');

        $array = [];

        $pallet = Pallet::with('detalles')->find($palletId);
        //dd($pallet);

        foreach ($pallet->detalles as $detalle) {

            // Inicializacion de array de valores de las condiciones
            $valores = (object) array(
                'insumo' => NULL,
                'producto' => NULL,
                'marca' => NULL,
                'familia' => NULL,
                'tipo_familia' => NULL
            );

            // Si es Producto Terminado Armar busquedas de condiciones
            if ($detalle->tipo_id == $PT) {

                $detalle->load('producto.marca.familia.tipo');
                $producto = $detalle->producto;

                $valores->producto = $producto->id;
                $valores->marca = $producto->marca->id;
                $valores->familia = $producto->marca->familia->id;
                $valores->tipo_familia = $producto->marca->familia->tipo->id;

                array_push($array, (new self)->arrayQuery($valores));


            // Si es Insumo Armar busquedas de condiciones
            } elseif ($detalle->tipo_id == $MP) {

                $detalle->load('insumo.familia.tipo');
                $insumo = $detalle->insumo;

                $valores->insumo = $insumo->id;
                $valores->familia = $insumo->familia->id;
                $valores->tipo_familia = $insumo->familia->tipo->id;

                array_push($array, (new self)->arrayQuery($valores));
            }

        }


        $conditionProducto = '';
        $conditionInsumo = '';
        $conditionMarca = '';
        $conditionFamilia = '';
        $conditionTipoFamilia = '';

        foreach ($array as $conditions) {

            $conditionProducto = $conditionProducto . $conditions['producto'];
            $conditionInsumo = $conditionInsumo . $conditions['insumo'];
            $conditionMarca = $conditionMarca . $conditions['marca'];
            $conditionFamilia = $conditionFamilia . $conditions['familia'];
            $conditionTipoFamilia = $conditionTipoFamilia . $conditions['tipo_familia'];
        }

        $baseQuery = "SELECT posicion.id FROM posicion,pos_cond WHERE posicion.id=pos_cond.posicion_id AND posicion.status_id=2";

        $query = $baseQuery . $conditionProducto .' LIMIT 1';

        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('condicion PRODUCTO');
            //dd($results);
            return $results[0];
        }

        $query = $baseQuery . $conditionInsumo . ' LIMIT 1';
        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('condicion INSUMO');
            //dd($results);
            return $results[0];
        }

        $query = $baseQuery . $conditionMarca . ' LIMIT 1';

        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('condicion MARCA');
            //dd($results);
            return $results[0];
        }

        $query = $baseQuery . $conditionFamilia . ' LIMIT 1';
        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('condicion FAMILIA');
            //dd($results);
            return $results[0];
        }

        $query = $baseQuery . $conditionTipoFamilia . ' LIMIT 1';
        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('condicion TIPO FAMILIA');
            //dd($results);
            return $results[0];
        }



        // si no cumple ninguna condicion buscar posicion sin condicion
        $query = "SELECT posicion.id FROM posicion WHERE posicion.id NOT IN (SELECT posicion_id FROM pos_cond WHERE posicion_id=posicion.id) AND posicion.status_id=2 LIMIT 1";
        $results = DB::select(DB::raw($query));

        if ($results) {

            //dump('sin condicion');
            //dd($results);
            return $results[0];
        }

        else {

            return NULL; // No positions founds
        }
    }

    /*
    |
    | Condiciones
    |
    */
    public function arrayQuery($object) {

        $insumo = $object->insumo == NULL ? 'NULL' : $object->insumo;
        $producto = $object->producto == NULL ? 'NULL' : $object->producto;
        $marca = $object->marca == NULL ? 'NULL' : $object->marca;
        $familia = $object->familia == NULL ? 'NULL' : $object->familia;
        $tipoFamilia = $object->tipo_familia == NULL ? 'NULL' : $object->tipo_familia;

        $conditionQueryInsumo =  $this->conditionQuery(self::COND_INSUMO,$insumo);
        $conditionQueryProducto = $this->conditionQuery(self::COND_PRODUCTO,$producto);
        $conditionQueryMarca = $this->conditionQuery(self::COND_MARCA,$marca);
        $conditionQueryFamilia = $this->conditionQuery(self::COND_FAMILIA,$familia);
        $conditionQueryTipoFam = $this->conditionQuery(self::COND_TIPO_FAMILIA,$tipoFamilia);


        return ['insumo' => $conditionQueryInsumo,
                'producto' => $conditionQueryProducto,
                'marca' => $conditionQueryMarca,
                'familia' => $conditionQueryFamilia,
                'tipo_familia' => $conditionQueryTipoFam
            ];
    }

    public function conditionQuery($tipo,$opcion) {

        $query = ' AND tipo_id=' . $tipo . ' AND opcion_id=' . $opcion;

        return $query;
    }


    /*
     * RELATIONS FUNCTIONS
     */

     public function pallet() {

         return $this->belongsTo('App\Models\Bodega\Pallet','pallet_id');
     }

    public function condicion() {

        return $this->hasOne('App\Models\Bodega\CondPos','posicion_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Bodega\PosicionStatus','status_id');
    }
}
