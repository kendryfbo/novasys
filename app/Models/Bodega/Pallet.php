<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Produccion\TerminoProceso;
use Illuminate\Database\Eloquent\Model;


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

    static function createPalletMPManual($request) {

        $pallet = DB::transaction( function() use($request) {

            $items = $request->items;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = $request->tipo_prod;
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
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->id,
                    'ing_tipo_id' => $tipoIngreso,
                    'ing_id' => $item->id,
                    'cantidad' => $cantidad,
                    'fecha_venc' => $item->fecha_venc,
                ]);
            };

            return $pallet;
        }); // end-transaction

        return $pallet;
    }


    static function getDataForBodega($id) {

        $pallet = self::with('detalles.producto','detalles.ingreso','detalles.tipo')->where('id',$id)->first();

        if (!$pallet) {

            return;
        }

        $pallet->detalleGroup = DB::table('pallet_detalle')
        ->join('productos', 'pallet_detalle.item_id', '=', 'productos.id')
        ->select('pallet_detalle.item_id', DB::raw('SUM(cantidad) as cantidad'), 'productos.codigo', 'productos.descripcion')
        ->where('pallet_id',$pallet->id)
        ->groupBy('item_id','codigo','descripcion')
        ->get();

        return $pallet;
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
