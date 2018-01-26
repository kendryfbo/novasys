<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produccion\TerminoProceso;


class Pallet extends Model
{

    protected $fillable= ['numero', 'medida_id', 'almacenado'];

    static function createFromProduccion($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = config('globalVars.PT');
            $pallet = Pallet::create([
                'numero' => $request->numero,
                'medida_id' => $request->medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);

                if ($item->procesar > $item->por_procesar) {

                    return;
                }


                $cantidad = $item->procesar;

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->prod_id,
                    'ing_tipo_id' => $tipoIngreso,
                    'ing_id' => $item->id,
                    'cantidad' => $cantidad,
                    'fecha_venc' => $item->fecha_venc,
                ]);

                $terminoProceso = TerminoProceso::find($item->id);
                $terminoProceso->procesado = 1;
                $terminoProceso->por_procesar = $terminoProceso->por_procesar - $cantidad;
                $terminoProceso->save();
            };
        return $pallet;
        }); // end-transaction

        return $pallet;
    }

    static function createPalletMP($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;

            $pallet = Pallet::create([
                'numero' => $request->numero,
                'medida_id' => $request->medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);

                $cantidad = $item->cantidad;

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'ing_tipo_id' => $item->ing_tipo_id,
                    'ing_id' => $item->ing_id,
                    'cantidad' => $cantidad,
                    'fecha_venc' => $item->fecha_venc,
                ]);

                $detalle = IngresoDetalle::with('ingreso')->find($item->id);

                $detalle->ingreso->procesado = 1;
                $detalle->por_almacenar = $detalle->por_almacenar - $cantidad;

                $detalle->ingreso->save();
                $detalle->save();
            };

            return $pallet;
        }); // end-transaction

        return $pallet;
    }

    static function getDataForBodega($id) {

        $pallet = self::with('detalles.ingreso','detalles.tipo')->where('id',$id)->first();

        if (!$pallet) {

            return;
        }

        foreach ($pallet->detalles as $detalle) {
            $detalle->load('producto');
        };

        $palletDetalleGroup = PalletDetalle::where('pallet_id',$id)->groupBy('tipo_id','item_id')->selectRaw('sum(cantidad) as cantidad, tipo_id,item_id')->get();

        foreach ($palletDetalleGroup as $detalle) {
            $detalle->load('producto');
        };
        $pallet->detalleGroup = $palletDetalleGroup;

        return $pallet;
    }

    static function getStockofProd($id) {

        $PT = config('globalVars.PT');
        return PalletDetalle::where('tipo_id',$PT)->where('item_id',$id)->sum('cantidad');
    }
    static function getStockofPremezcla($id) {

        $PP = config('globalVars.PP');
        return PalletDetalle::where('tipo_id',$PP)->where('item_id',$id)->sum('cantidad');
    }
    static function getStockofInsumo($id) {

        $MP = config('globalVars.MP');
        return PalletDetalle::where('tipo_id',$MP)->where('item_id',$id)->sum('cantidad');
    }
    /*
    | public functions
    */

    // descontar Pallet dado el id de Detalle
    public function subtract($id,$cantidad) {

        //dd('pallet substract');

        $detalle = $this->detalles->find($id);
        $detalle->subtract($cantidad);
    }

    public function isEmpty() {

        $total = $this->detalles->sum('cantidad');

        if ($total <= 0) {

            return true;
        }

        return false;
    }

   /*
    * Relations Table
    */
    public function detalles() {

        return $this->hasMany('App\Models\Bodega\PalletDetalle','pallet_id');
    }
    public function medida() {

        return $this->belongsTo('App\Models\Bodega\PalletMedida','medida_id');
    }

    public function posicion() {

        return $this->hasOne('App\Models\Bodega\Posicion','pallet_id');
    }




}
