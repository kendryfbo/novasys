<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Bodega\PalletDetalle;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $fillable = ['numero', 'descripcion', 'tipo_id', 'item_id', 'procesado', 'fecha_ing', 'user_id'];


    static function register($request) {

        $ingreso = DB::transaction(function() use($request) {

            $fecha = $request->fecha;
            $descripcion = $request->descripcion;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = $request->tipo_prod;
            $items = $request->items;
            $procesado = 0;
            $usuario = $request->user()->id;

            $numero = Ingreso::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

    			$numero = 1;

    		} else {

    			$numero++;
    		};

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'fecha_ing' => $fecha,
                'procesado' => $procesado,
                'user_id' => $usuario,
            ]);


            foreach ($items as $item) {

                $item = json_decode($item);

                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->id,
                    'fecha_venc' => $item->fecha_venc,
                    'cantidad' => $item->cantidad,
                    'ingresado' => 0,
                ]);

                PalletDetalle::create([
                    'pallet_id' => NULL,
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->id,
                    'ing_tipo_id' => $tipoIngreso,
                    'ing_id' => $ingreso->id,
                    'cantidad' => $item->cantidad,
                    'fecha_venc' => $item->fecha_venc,
                ]);

            };

            return $ingreso;

        });

        return $ingreso;
    }


    /*
    |
    | Relationships
    |
    */

    public function usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }

    public function tipo() {

        return $this->belongsTo('App\Models\Bodega\IngresoTipo','tipo_id');
    }
}
