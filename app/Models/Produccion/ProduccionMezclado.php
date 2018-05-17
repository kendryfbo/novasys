<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Nivel;
use App\Models\Formula;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\FormulaDetalle;
use App\Models\Config\StatusDocumento;

class ProduccionMezclado extends Model
{
    protected $table= 'produccion_mezclado';
    protected $fillable = ['numero','premezcla_id', 'user_id', 'cant_batch', 'fecha', 'status_id'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $premezclaID = $request->premezclaID;
            $nivelProd = $request->nivelID;
            $user = $request->user()->id;
            $fecha = $request->fecha;
            $status = StatusDocumento::pendienteID();
            $numero = ProduccionMezclado::nextNumber();

            $insumosProd = FormulaDetalle::where('formula_id',$formulaID)
                ->where('nivel_id',$nivelProd)->get();


            $prodMezclado = ProduccionMezclado::create([
                'numero' => $numero,
                'premezcla_id' => $premezclaID,
                'user_id' => $user,
                'cant_batch' => $cantBatch,
                'fecha' => $fecha,
                'status_id' => $status,
            ]);

            foreach ($insumosProd as $insumo) {

                $cantxbatch = $insumo->cantxbatch * $cantBatch;

                ProdMezDetalle::create([
                    'prodmez_id' => $prodMezclado->id,
                    'insumo_id' => $insumo->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };

            return $prodMezclado;
        },5);
    }


    static function processMezclado($prodMezcladoID,$bodegaID) {

        $prodMezclado = ProduccionMezclado::with('detalles')->where('id',$prodMezcladoID)->first();
        $pendiente = StatusDocumento::pendienteID();

        if($prodMezclado->status_id != $pendiente) {

            dd('ERROR - Produccion de Mezclado ya ha sido Procesada');
        }

        $prodMezclado = DB::transaction( function() use($prodMezclado,$bodegaID) {

            $tipoProd = TipoFamilia::getInsumoID();

            foreach ($prodMezclado->detalles as $detalle) {

                $detalle->item_id = $detalle->insumo_id;

                $posiciones = Bodega::descount($bodegaID,$tipoProd,$detalle);
            }

            $prodMezclado->status_id = StatusDocumento::completaID();
            $prodMezclado->save();

            return $prodMezclado;
        },5);

        return $prodMezclado;
    }

    // Relationships

    public function detalles() {

        return $this->hasMany('App\Models\Produccion\ProdMezDetalle', 'prodmez_id', 'id');
    }

    public function premezcla() {

        return $this->belongsTo('App\Models\Premezcla','premezcla_id');
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
