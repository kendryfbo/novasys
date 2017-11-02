<?php

namespace App\Models\Bodega;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Produccion\TerminoProceso;
use Illuminate\Database\Eloquent\Model;


class Pallet extends Model
{

    protected $fillable= ['numero', 'medida_id'];

    static function createFromProduccion($request) {

        $pallet = DB::transaction( function() use($request) {

            //dd($request->all());
            $items = $request->items;

            $pallet = Pallet::create([
                'numero' => $request->numero,
                'medida_id' => $request->medida,
            ]);

            foreach ( $items as $item) {

                $item = json_decode($item);

                $total = $item->producidas - $item->rechazadas;

                PalletDetalle::create([
                    'pallet_id' => $pallet->id,
                    'tipo_id' => 1, // TEMPORAL en analisis si es necesario
                    'item_id' => $item->prod_id,
                    'codigo' => $item->producto->codigo,
                    'descripcion' => $item->producto->descripcion,
                    'cantidad' => $total,
                    'fecha_venc' => $item->fecha_venc,
                    'lote' => $item->lote
                ]);

                $terminoProceso = TerminoProceso::find($item->id);
                $terminoProceso->almacenado = 1;
                $terminoProceso->save();
            };
        return $pallet;
        }); // end-transaction

        return $pallet;
    }

   /*
    * Relations Table
    */
    public function detalles() {

        return $this->hasMany('App\Models\Bodega\PalletDetalle','pallet_id');
    }




}
