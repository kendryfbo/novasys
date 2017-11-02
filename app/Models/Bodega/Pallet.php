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

        DB::transaction( function() use($request) {

            //dd($request->all());
            $items = $request->items;

            $pallet = Pallet::create([
                'numero' => $request->numero,
                'medida_id' => $request->medida,
            ]);

            $asd = ['pallet_id', 'tipo_id', 'item_id', 'codigo', 'descripcion', 'cantidad', 'fecha_venc', 'lote'];

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

        }); // end-transaction
    }

   /*
    * Relations Table
    */
    public function pallet() {

        return $this->hasMany('App\Models\Bodega\PalletDetalle','pallet_id');
    }




}
