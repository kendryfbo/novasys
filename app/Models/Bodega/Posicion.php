<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;

class Posicion extends Model
{
    protected $table = 'posicion';
    protected $fillable = ['bodega_id', 'bloque', 'columna', 'estante', 'medida', 'status_id', 'pallet_id'];


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
