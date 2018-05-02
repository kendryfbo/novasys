<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Config\StatusDocumento ;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produccion\TerminoProceso;


class Pallet extends Model
{
    protected $fillable= ['numero', 'medida_id', 'almacenado'];

    static function storeFromProduccion($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $tipoIngreso = $request->tipo_ingreso;
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
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'ing_tipo_id' => $item->ingreso->tipo_id,
                    'ing_id' => $item->ingreso->id,
                    'cantidad' => $cantidad,
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

    static function storePalletMP($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $fechaIng = $request->fecha;

            $pallet = Pallet::create([
                'numero' => $request->numero,
                'medida_id' => $request->medida,
                'almacenado' => 0,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);

                $cantidad = $item->cantidad;
                $fechaVenc = null;// $item->fecha_venc ? $item->fecha_venc : null; // no esta registrando fecha de vencimiento - Corregir

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'ing_tipo_id' => $item->ing_tipo_id,
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
