<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Nivel;
use App\Models\Formula;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\Bodega\Ingreso;
use App\Models\FormulaDetalle;
use App\Models\Bodega\Posicion;
use App\Models\Bodega\IngresoTipo;
use App\Models\Config\StatusDocumento;

class ProduccionPremezcla extends Model
{
    protected $table = 'produccion_premezcla';
    protected $fillable = ['numero','formula_id', 'user_id', 'cant_batch', 'fecha_prod', 'fecha_venc', 'status_id'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $premezclaID = $request->premezclaID;
            $nivelPremix = $request->nivelID;
            $fechaProd = $request->fecha_prod;
            $fechaVenc = $request->fecha_venc;
            $user = $request->user()->id;
            $status = StatusDocumento::pendienteID();

            $insumosPremix = FormulaDetalle::where('formula_id',$formulaID)
                ->where('nivel_id',$nivelPremix)->get();

            $numero = ProduccionPremezcla::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {
    			$numero = 1;
    		} else {
    			$numero++;
    		};
            $prodPrem = ProduccionPremezcla::create([
                'numero' => $numero,
                'formula_id' => $formulaID,
                'user_id' => $user,
                'cant_batch' => $cantBatch,
                'fecha_prod' => $fechaProd,
                'fecha_venc' => $fechaVenc,
                'status_id' => $status,
            ]);
            foreach ($insumosPremix as $insumoPremix) {

                $cantxbatch = round(($insumoPremix->cantxbatch * $cantBatch),2);

                ProdPremDetalle::create([
                    'prodprem_id' => $prodPrem->id,
                    'insumo_id' => $insumoPremix->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };
            // generar ingreso
            $ingreso = Ingreso::registerFromProdPrem($prodPrem);

            return $prodPrem;
        },5);
    }

    static function processPremix($prodPremID,$bodegaID) {

        $prodPrem = ProduccionPremezcla::with('detalles')->where('id',$prodPremID)->first();
        $pendiente = StatusDocumento::pendienteID();

        if($prodPrem->status_id != $pendiente) {

            dd('ERROR - Produccion de Premezcla ya ha sido Procesada');
        }

        $ProdPrem = DB::transaction( function() use($prodPrem,$bodegaID) {

            $tipoProd = TipoFamilia::getInsumoID();
            $tipoIngreso = IngresoTipo::prodPremID();

            foreach ($prodPrem->detalles as $detalle) {

                $itemID = $detalle->insumo_id;
                $cantidad = $detalle->cantidad;

                $posiciones = Bodega::descount($bodegaID,$tipoProd,$itemID,$cantidad);
            }
            // buscar ingreso
            $ingreso = Ingreso::where('tipo_id',$tipoIngreso)->where('item_id',$prodPrem->id)->first();
            // generar Pallet
            $pallet = Pallet::storeFromIngreso($ingreso->id);
            // Buscar Posicion para Pallet
            $bodegaMez = Bodega::getBodMezcladoID(); // premezcla se almacena en bodega Mezclado automaticamente
            $posicion = Posicion::findPositionForPallet($bodegaMez,$pallet->id);
            // Ingresar pallet a Bodega
            Bodega::storePalletInPosition($posicion->id,$pallet->id);
            // actualizar status
            $prodPrem->status_id = StatusDocumento::completaID();
            $prodPrem->save();

            return $prodPrem;
        },5);

        return $prodPrem;
    }

    static function remove($id) {

        $prodPrem = DB::transaction(function() use($id){

            $prodPrem = ProduccionPremezcla::find($id);
            $tipo = IngresoTipo::prodPremID();
            $status = StatusDocumento::pendienteID();

            if ($prodPrem->status_id != $status) {

                return;
            }

            Ingreso::where('tipo_id',$tipo)->where('item_id',$id)->delete();

            $prodPrem->delete();

            return $prodPrem;
        },5);

        return $prodPrem;
    }

    /*
    |
    | Relationships
    |
    */
    public function detalles() {

        return $this->hasMany('App\Models\Produccion\ProdPremDetalle', 'prodprem_id', 'id');
    }

    public function formula() {

        return $this->belongsTo('App\Models\Formula','formula_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }
}
