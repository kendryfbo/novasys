<?php

namespace App\Models\Bodega;

use DB;
use Carbon\Carbon;
use App\Models\Bodega\PalletMedida;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Config\StatusDocumento ;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produccion\TerminoProceso;


class Pallet extends Model
{
    protected $fillable= ['numero', 'num_fisico', 'medida_id', 'almacenado'];

    static function storeFromProduccion($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $tipoIngreso = $request->tipo_ingreso;
            $pallet = Pallet::create([
                'numero' => $request->numero,
                'num_fisico' => $request->num_fisico,
                'medida_id' => $request->medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);
                $ingDetalle = IngresoDetalle::with('ingreso')->find($item->id);

                if ($item->procesar > $ingDetalle->por_procesar) {

                    return;
                }

                $cantidad = $item->procesar;
                $ingDetalle->por_procesar -= $cantidad;
                $ingDetalle->save();
                $ingDetalle->ingreso->updateStatus();
                $ingDetalle->ingreso->save();

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'ing_tipo_id' => $item->ingreso->tipo_id,
                    'ing_id' => $item->ingreso->id,
                    'cantidad' => $cantidad,
                    'fecha_ing' => $item->fecha_ing,
                    'fecha_venc' => $item->fecha_venc,
                ]);

                $terminoProceso = TerminoProceso::find($item->ingreso->item_id);
                $terminoProceso->ingresadas = $terminoProceso->ingresadas + $cantidad;

                if ($terminoProceso->ingresadas >= $terminoProceso->producidas) {

                    $terminoProceso->status_id = StatusDocumento::completaID();
                } else {
                    $terminoProceso->status_id = StatusDocumento::ingresadaID();
                }

                $terminoProceso->save();
            };
        return $pallet;
        }); // end-transaction

        return $pallet;
    }

    static function storeFromIngreso($ingresoID) {

        $pallet = DB::transaction( function() use($ingresoID) {

            $ingreso = Ingreso::with('detalles')->where('id',$ingresoID)->first();
            $items = $ingreso->detalles;
            $numero = Carbon::now()->format('YmdHis');
            $medida = PalletMedida::altoID();

            $pallet = Pallet::create([
                'numero' => $numero,
                'num_fisico' => null,
                'medida_id' => $medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $cantidad = $item->cantidad;
                $fechaVenc = $item->fecha_venc;
                $fechaIng = $item->fecha_ing;

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'ing_tipo_id' => $ingreso->tipo_id,
                    'ing_id' => $item->ing_id,
                    'cantidad' => $cantidad,
                    'fecha_ing' => $fechaIng,
                    'fecha_venc' => $fechaVenc,
                ]);

                $detalle = IngresoDetalle::with('ingreso')->find($item->id);

                $detalle->por_procesar = $detalle->por_procesar - $cantidad;
                $detalle->save();

                $detalle->ingreso->updateStatus();
                $detalle->ingreso->save();
            };

            return $pallet;
        }); // end-transaction

        return $pallet;
    }

    static function storePallet($palletInfo) {

        $pallet = DB::transaction( function() use($palletInfo) {


            $items = $palletInfo->detalles;

            $pallet = Pallet::create([
                'numero' => $palletInfo->numero,
                'num_fisico' => $palletInfo->num_fisico,
                'medida_id' => $palletInfo->medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);

                $ingDetalleID = $item->id;
                $palletID = $pallet->id;
                $cantidad = $item->cantidad;
                $fechaVenc = null;// $item->fecha_venc ? $item->fecha_venc : null; // no esta registrando fecha de vencimiento - Corregir
                $fechaIng = $item->fecha_ing;
                $tipoID  = $item->tipo_id;
                $itemID = $item->item_id;
                $ingTipoID = $item->ing_tipo_id;
                $ingID = $item->ing_id;

                PalletDetalle::create([
                    'pallet_id' => $palletID,
                    'tipo_id' => $tipoID,
                    'item_id' => $itemID,
                    'ing_tipo_id' => $ingTipoID,
                    'ing_id' => $ingID,
                    'cantidad' => $cantidad,
                    'fecha_ing' => $fechaIng,
                    'fecha_venc' => $fechaVenc,
                ]);

                if ($ingDetalleID) {

                    $detalle = IngresoDetalle::with('ingreso')->find($item->id);
                    $detalle->por_procesar = $detalle->por_procesar - $cantidad;
                    $detalle->save();
                    $detalle->ingreso->updateStatus();
                    $detalle->ingreso->save();
                }
            };
            return $pallet;
        },5); // end-transaction

        return $pallet;
    }

    static function storeItemToPallet($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $palletID = $request->pallet_id;

            foreach ( $items as $item) {

                $item = json_decode($item);

                $ingDetalleID = $item->id;
                $cantidad = $item->cantidad;
                $fechaVenc = $item->fecha_venc;
                $fechaIng = $item->fecha_ing;
                $tipoID  = $item->tipo_id;
                $itemID = $item->item_id;
                $ingTipoID = $item->ing_tipo_id;
                $ingID = $item->ing_id;

                PalletDetalle::create([
                    'pallet_id' => $palletID,
                    'tipo_id' => $tipoID,
                    'item_id' => $itemID,
                    'ing_tipo_id' => $ingTipoID,
                    'ing_id' => $ingID,
                    'cantidad' => $cantidad,
                    'fecha_ing' => $fechaIng,
                    'fecha_venc' => $fechaVenc,
                ]);

                Ingreso::descountItemFromIngreso($item->id,$cantidad);

            };

            $pallet = Pallet::find($palletID);

            return $pallet;
        },5); // end-transaction

        return $pallet;
    }

    static function moveItemBetweenPallet($request) {

        DB::transaction(function() use($request){

            $palletOneID = $request->palletOneID;
            $palletDetalleID = $request->palletDetalleID;
            $palletTwoID = $request->palletTwoID;
            $cantidad = $request->cantidad;

            $posicion = Posicion::where('pallet_id',$palletOneID)->first();
            $palletDetalle = PalletDetalle::find($palletDetalleID);

            $posicion->subtract($palletDetalle->id,$cantidad);
            $palletDetalleTwo = PalletDetalle::create([
                'pallet_id' => $palletTwoID,
                'tipo_id' => $palletDetalle->tipo_id,
                'item_id' => $palletDetalle->item_id,
                'ing_tipo_id' => $palletDetalle->ing_tipo_id,
                'ing_id' => $palletDetalle->ing_id,
                'cantidad' => $cantidad,
                'fecha_ing' => $palletDetalle->fecha_ing,
                'fecha_venc' => $palletDetalle->fecha_venc,
            ]);

        },5);
    }

    static function getDataForBodega($id) {

        $pallet = self::with('detalles.ingreso.detalles','detalles.tipo')->where('id',$id)->first();

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

    static function getStockofProd($id = null) {

        $PT = config('globalVars.PT');

        if ($id) {

            return PalletDetalle::where('tipo_id',$PT)->where('item_id',$id)->sum('cantidad');

        } else {

            $table = (new PalletDetalle)->getTable();

            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(cantidad) as cantidad'))
            ->where('tipo_id',$PT)
            ->groupBy('item_id','tipo_id')
            ->get();
        }
    }

    static function getStockofPremezcla($id = null) {

        $PP = config('globalVars.PP');

        if ($id) {
            return PalletDetalle::where('tipo_id',$PP)->groupBy('tipo_id','item_id')->sum('cantidad');

        } else {

            $table = (new PalletDetalle)->getTable();
            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(cantidad) as cantidad'))
            ->where('tipo_id',$PP)
            ->groupBy('item_id','tipo_id')
            ->get();

        }
    }

    static function getStockofInsumo($id = null) {

        $MP = config('globalVars.MP');

        if ($id) {
            return PalletDetalle::where('tipo_id',$MP)->groupBy('tipo_id','item_id')->sum('cantidad');

        } else {

            $table = (new PalletDetalle)->getTable();
            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(cantidad) as cantidad'))
            ->where('tipo_id',$MP)
            ->groupBy('item_id','tipo_id')
            ->get();

        }
    }

    // generate pallet num (year-month-day-hours-minutes-seconds)
    static function getNewPalletNum() {

        return Carbon::now()->format('YmdHis');
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
