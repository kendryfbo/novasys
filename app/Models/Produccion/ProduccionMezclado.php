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

class ProduccionMezclado extends Model
{
    protected $table= 'produccion_mezclado';
    protected $fillable = ['numero','formula_id', 'user_id', 'cant_batch', 'fecha_prod', 'fecha_venc', 'status_id'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $reprocesoID = $request->reprocesoID;
            $nivelProd = $request->nivelID;
            $nivelPremix = Nivel::premixID();
            $user = $request->user()->id;
            $fechaProd = $request->fecha_prod;
            $fechaVenc = $request->fecha_venc;
            $status = StatusDocumento::pendienteID();
            $numero = ProduccionMezclado::nextNumber();

            $insumosProd = FormulaDetalle::where('formula_id',$formulaID)
                ->where('nivel_id',$nivelProd)->get();
            $detalleFormula = FormulaDetalle::where('formula_id',$formulaID)
                ->whereIn('nivel_id',[$nivelProd,$nivelPremix])
                ->get();

            $totalReproceso = $detalleFormula->sum('cantxbatch')*$cantBatch;

            $prodMezclado = ProduccionMezclado::create([
                'numero' => $numero,
                'formula_id' => $formulaID,
                'user_id' => $user,
                'cant_batch' => $cantBatch,
                'fecha_prod' => $fechaProd,
                'fecha_venc' => $fechaVenc,
                'status_id' => $status,
            ]);
            $prodMezclado->total_rpr = $totalReproceso;

            foreach ($insumosProd as $insumo) {

                $cantxbatch = $insumo->cantxbatch * $cantBatch;

                ProdMezDetalle::create([
                    'prodmez_id' => $prodMezclado->id,
                    'insumo_id' => $insumo->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };
            // generar ingreso
            $ingreso = Ingreso::registerFromProdMez($prodMezclado);

            return $prodMezclado;
        },5);
    }


    static function processMezclado($prodMezID,$bodegaID) {

        $prodMez = ProduccionMezclado::with('detalles','formula.premezcla')->where('id',$prodMezID)->first();
        $pendiente = StatusDocumento::pendienteID();

        if($prodMez->status_id != $pendiente) {

            dd('ERROR - Produccion de Mezclado ya ha sido Procesada');
        }

        $prodMez = DB::transaction( function() use($prodMez,$bodegaID) {

            $tipoProd = TipoFamilia::getInsumoID();
            $tipoPremix = TipoFamilia::getPremezclaID();
            $tipoIngreso = IngresoTipo::prodMezID();

            foreach ($prodMez->detalles as $detalle) {

                $itemID = $detalle->insumo_id;
                $cantidad = $detalle->cantidad;

                $posiciones = Bodega::descount($bodegaID,$tipoProd,$itemID,$cantidad);
            }
            // descuento de Premix
            $premezcla = collect();
            $itemID = $prodMez->formula->premezcla->id;
            $cantidad = $prodMez->cant_batch;

            Bodega::descount($bodegaID,$tipoPremix,$itemID,$cantidad);
            // buscar ingreso
            $ingreso = Ingreso::where('tipo_id',$tipoIngreso)->where('item_id',$prodMez->id)->first();
            // generar Pallet
            $pallet = Pallet::storeFromIngreso($ingreso->id);
            // Buscar Posicion para Pallet
            $bodegaMez = Bodega::getBodMezcladoID(); // Reproceso se almacena en bodega Mezclado automaticamente
            $posicion = Posicion::findPositionForPallet($bodegaMez,$pallet->id);
            // Ingresar pallet a Bodega
            Bodega::storePalletInPosition($posicion->id,$pallet->id);
            // actualizar status
            $prodMez->status_id = StatusDocumento::completaID();
            $prodMez->save();

            return $prodMez;
        },5);

        return $prodMez;
    }

    static function remove($id) {

        $prodMezclado = DB::transaction(function() use($id){

            $prodMezclado = ProduccionMezclado::find($id);
            $tipo = IngresoTipo::prodMezID();
            $status = StatusDocumento::pendienteID();

            if ($prodMezclado->status_id != $status) {

                return;
            }

            Ingreso::where('tipo_id',$tipo)->where('item_id',$id)->delete();

            $prodMezclado->delete();

            return $prodMezclado;
        },5);

        return $prodMezclado;
    }

    // Relationships

    public function detalles() {

        return $this->hasMany('App\Models\Produccion\ProdMezDetalle', 'prodmez_id', 'id');
    }

    public function formula() {

        return $this->belongsTo('App\Models\Formula','formula_id');
    }


    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }

    /*
    *   PRIVATE FUNCTIONS
    */
    static private function nextNumber() {

        $numero = ProduccionMezclado::orderBy('numero','desc')->pluck('numero')->first();

        if (is_null($numero)) {
            $numero = 1;
        } else {
            $numero++;
        };

        return $numero;

    }
}
