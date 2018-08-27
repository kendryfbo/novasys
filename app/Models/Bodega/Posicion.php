<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\TipoFamilia;
use App\Models\Bodega\Pallet;
use App\Models\Bodega\PalletMedida;
use App\Models\Bodega\PalletDetalle;

class Posicion extends Model
{
    /* status de posiciones */
    const DESHABILITADO = 1;
    const DISPONIBLE = 2;
    const OCUPADO = 3;
    const RESERVADO = 4;

    /* condiciones disponibles */
    const COND_TIPO_FAMILIA = 1;
    const COND_FAMILIA = 2;
    const COND_MARCA = 3;
    const COND_PRODUCTO = 4;
    const COND_INSUMO = 5;
    const COND_PREMEZCLA = 6;
    const COND_REPROCESO = 7;

    protected $table = 'posicion';
    protected $fillable = ['bodega_id', 'bloque', 'columna', 'estante', 'medida_id', 'status_id', 'pallet_id'];

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

        $query = "SELECT * FROM posicion,cond_pos WHERE posicion.id=cond_pos.posicion_id AND posicion.status_id=".self::DISPONIBLE." ". $queryCond1;
        $results = DB::select(DB::raw($query));

        if ($results) {

            dd($results);
        }
        $query = "SELECT * FROM posicion,cond_pos WHERE posicion.id=cond_pos.posicion_id AND posicion.status_id=".self::DISPONIBLE." ". $queryCond2;
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

        $PT = TipoFamilia::getProdTermID();
        $MP = TipoFamilia::getInsumoID();
        $PR = TipoFamilia::getPremezclaID();

        $array = [];

        $pallet = Pallet::with('detalles')->find($palletId);
        $medidaPallet = $pallet->medida_id;

        foreach ($pallet->detalles as $detalle) {

            // Inicializacion de array de valores de las condiciones
            $valores = (object) array(
                'insumo' => NULL,
                'producto' => NULL,
                'premezcla' => NULL,
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
            } else if ($detalle->tipo_id == $MP) {

                $detalle->load('insumo.familia.tipo');
                $insumo = $detalle->insumo;

                $valores->insumo = $insumo->id;
                $valores->familia = $insumo->familia->id;
                $valores->tipo_familia = $insumo->familia->tipo->id;

                array_push($array, (new self)->arrayQuery($valores));

            // Si es Premezcla Armar busquedas de condiciones
            } else if ($detalle->tipo_id == $PR) {

                $detalle->load('premezcla.familia.tipo');
                $premezcla = $detalle->premezcla;

                $valores->premezcla = $premezcla->id;
                $valores->familia = $premezcla->familia->id;
                $valores->tipo_familia = $premezcla->familia->tipo->id;

                array_push($array, (new self)->arrayQuery($valores));
            }

        }


        $conditionProducto = '';
        $conditionInsumo = '';
        $conditionPremezcla = '';
        $conditionMarca = '';
        $conditionFamilia = '';
        $conditionTipoFamilia = '';

        foreach ($array as $conditions) {

            $conditionProducto = $conditionProducto . $conditions['producto'];
            $conditionInsumo = $conditionInsumo . $conditions['insumo'];
            $conditionPremezcla = $conditionPremezcla . $conditions['premezcla'];
            $conditionMarca = $conditionMarca . $conditions['marca'];
            $conditionFamilia = $conditionFamilia . $conditions['familia'];
            $conditionTipoFamilia = $conditionTipoFamilia . $conditions['tipo_familia'];
        }

        if ($medidaPallet == palletMedida::bajoID()) {

            $baseQuery = "SELECT posicion.id FROM posicion,pos_cond WHERE posicion.bodega_id=" . $bodegaId . " AND posicion.id=pos_cond.posicion_id AND posicion.status_id=" . self::DISPONIBLE ." ";

        } else {

            $baseQuery = "SELECT posicion.id FROM posicion,pos_cond WHERE posicion.bodega_id=" . $bodegaId . " AND posicion.id=pos_cond.posicion_id AND posicion.status_id=" . self::DISPONIBLE . " AND posicion.medida_id=" . $medidaPallet;
        }

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

        $palletAlto = PalletMedida::altoID();
        $palletBajo = PalletMedida::bajoID();

        // si no cumple ninguna condicion buscar posicion sin condicion
        $query = "SELECT posicion.id FROM posicion WHERE posicion.bodega_id=" . $bodegaId . " AND posicion.id NOT IN (SELECT posicion_id FROM pos_cond WHERE posicion_id=posicion.id) AND posicion.status_id=".self::DISPONIBLE." ";

        /*
        |   medida_id Se ordena DESC para buscar primero pallets ALTOS y ASC para buscar primero pallets BAJOS
        */

        // si pallet es alto buscar posicion alta si no, buscar posicion baja
        if ($medidaPallet == $palletAlto) {

            $query = $query . " AND (posicion.medida_id=" . $palletAlto . " OR posicion.medida_id=" . $palletBajo . ")
            ORDER BY medida_id DESC, bloque ASC, columna ASC, estante ASC  LIMIT 1";

        // de lo contrario buscar posicion baja si no, buscar posicion alta
        } else {

            $query = $query . " AND (posicion.medida_id=" . $palletBajo . " OR posicion.medida_id=" . $palletAlto . ")
            ORDER BY medida_id ASC, bloque ASC, columna ASC, estante ASC LIMIT 1";
        }

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

    static function getPositionThatContainItem($bodega,$tipo,$id) {

        $posicion = [];
        $ocupado = PosicionStatus::ocupadoID();

        $query = "SELECT pos.id as id, pa.numero as pallet_num, SUM(pd.cantidad) as existencia
                    FROM posicion AS pos JOIN pallet_detalle AS pd ON pos.pallet_id=pd.pallet_id JOIN pallets as pa ON pa.id=pd.pallet_id
                    WHERE pd.tipo_id=".$tipo." AND pd.item_id=".$id;

        if ($bodega){

            $query = $query . " AND pos.status_id=".$ocupado." AND pos.bodega_id=".$bodega;
        }

        $query = $query ." GROUP BY id ORDER BY fecha_ing ASC, pallet_num ASC LIMIT 1";

        $results = DB::select(DB::raw($query));

        if (!$results) {

            return $posicion;
        }

        $posicion = collect(['id' => $results[0]->id,'existencia' => $results[0]->existencia]);

        return $posicion;
    }
    static function getPositionOfItem($pos,$tipo,$id) {

        $posicion = [];
        $ocupado = PosicionStatus::ocupadoID();

        $query = "SELECT pos.id as id, pd.id as detalle_id, pd.lote as detalle_lote,pa.numero as pallet_num, pd.cantidad as existencia
                    FROM posicion AS pos JOIN pallet_detalle AS pd ON pos.pallet_id=pd.pallet_id JOIN pallets as pa ON pa.id=pd.pallet_id
                    WHERE pd.tipo_id=".$tipo." AND pd.item_id=".$id." AND pos.status_id=".$ocupado." AND pos.id=".$pos;

        $query = $query ." ORDER BY fecha_ing ASC, pallet_num ASC LIMIT 1";
        $results = DB::select(DB::raw($query));

        if (!$results) {

            return $posicion;
        }
        $posicion = Posicion::find($results[0]->id);
        $posicion->detalle_id = $results[0]->detalle_id;
        $posicion->detalle_lote = $results[0]->detalle_lote;
        $posicion->pallet_num = $results[0]->pallet_num;
        $posicion->existencia = $results[0]->existencia;

        return $posicion;
    }

    static function palletIsStored($palletId) {

        $pallet = self::where('pallet_id',$palletId)->first();

        if ($pallet) {
            return true;
        }
        return false;
    }

    static function changePositionPallet($anterior,$nueva) {

        DB::transaction(function() use($anterior,$nueva){

            $posAnterior = Posicion::find($anterior);
            $posNueva = Posicion::find($nueva);

            $posNueva->pallet_id = $posAnterior->pallet_id;
            $posNueva->status_id = PosicionStatus::ocupadoID();
            $posAnterior->pallet_id = null;
            $posAnterior->status_id = PosicionStatus::disponibleID();
            $posAnterior->save();
            $posNueva->save();
        },5);
    }

    static function blockPosition($posicionID) {

        $status = PosicionStatus::bloqueadoID();
        $posicion = Posicion::find($posicionID);

        $posicion->status_id = $status;
        $posicion->save();

        return $posicion;
    }

    static function unBlockPosition($posicionID) {

        $posicion = Posicion::find($posicionID);

        if ($posicion->pallet_id) {
            $status = PosicionStatus::ocupadoID();
        } else {
            $status = PosicionStatus::disponibleID();
        }

        $posicion->status_id = $status;
        $posicion->save();

        return $posicion;
    }
    /*
    * PUBLIC FUNCTIONS
    */

    public function subtract($detalle_id,$cantidad) {

        $this->pallet->subtract($detalle_id,$cantidad);

        if ($this->pallet->isEmpty()) {

            unset($this->detalle_id);
            unset($this->existencia);

            $this->pallet_id = NULL;
            $this->status_id = self::DISPONIBLE;

            $this->save();

            $this->pallet->delete();
        }
    }

    public function format() {

        $bloque = sprintf("%02d", $this->bloque);
        $columna = sprintf("%02d", $this->columna);
        $estante = sprintf("%02d", $this->estante);

        $formato = $bloque . $columna . $estante;

        return $formato;
    }

    public function insertPallet($palletId) {

        DB::transaction(function () use ($palletId) {

            $pallet = Pallet::find($palletId);
            $pallet->almacenado = 1;
            $pallet->save();
            $this->pallet_id = $pallet->id;
            $this->status_id = self::OCUPADO;
            $this->save();
        },5);
    }
    /*
    |
    | Condiciones
    |
    */
    public function arrayQuery($object) {

        $insumo = $object->insumo == NULL ? 'NULL' : $object->insumo;
        $premezcla = $object->premezcla == NULL ? 'NULL' : $object->premezcla;
        $producto = $object->producto == NULL ? 'NULL' : $object->producto;
        $marca = $object->marca == NULL ? 'NULL' : $object->marca;
        $familia = $object->familia == NULL ? 'NULL' : $object->familia;
        $tipoFamilia = $object->tipo_familia == NULL ? 'NULL' : $object->tipo_familia;

        $conditionQueryInsumo =  $this->conditionQuery(self::COND_INSUMO,$insumo);
        $conditionQueryPremezcla =  $this->conditionQuery(self::COND_PREMEZCLA,$premezcla);
        $conditionQueryProducto = $this->conditionQuery(self::COND_PRODUCTO,$producto);
        $conditionQueryMarca = $this->conditionQuery(self::COND_MARCA,$marca);
        $conditionQueryFamilia = $this->conditionQuery(self::COND_FAMILIA,$familia);
        $conditionQueryTipoFam = $this->conditionQuery(self::COND_TIPO_FAMILIA,$tipoFamilia);


        return ['insumo' => $conditionQueryInsumo,
                'premezcla' => $conditionQueryPremezcla,
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
     public function bodega() {

         return $this->belongsTo('App\Models\Bodega\Bodega','bodega_id');
     }
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
