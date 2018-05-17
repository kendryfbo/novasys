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

class ProduccionPremezcla extends Model
{
    protected $table = 'produccion_premezcla';
    protected $fillable = ['numero','premezcla_id', 'user_id', 'cant_batch', 'fecha','status_id'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $premezclaID = $request->premezclaID;
            $nivelPremix = $request->nivelID;
            $fecha = $request->fecha;
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
            $prodPremezcla = ProduccionPremezcla::create([
                'numero' => $numero,
                'premezcla_id' => $premezclaID,
                'user_id' => $user,
                'cant_batch' => $cantBatch,
                'fecha' => $fecha,
                'status_id' => $status,
            ]);

            foreach ($insumosPremix as $insumoPremix) {

                $cantxbatch = round(($insumoPremix->cantxbatch * $cantBatch),2);
                
                ProdPremDetalle::create([
                    'prodprem_id' => $prodPremezcla->id,
                    'insumo_id' => $insumoPremix->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };

            return $prodPremezcla;
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

            foreach ($prodPrem->detalles as $detalle) {

                $detalle->item_id = $detalle->insumo_id;

                $posiciones = Bodega::descount($bodegaID,$tipoProd,$detalle);
            }

            $prodPrem->status_id = StatusDocumento::completaID();
            $prodPrem->save();

            return $prodPrem;
        },5);

        return $prodPrem;
    }

    // Relationships

    public function detalles() {

        return $this->hasMany('App\Models\Produccion\ProdPremDetalle', 'prodprem_id', 'id');
    }

    public function premezcla() {

        return $this->belongsTo('App\Models\Premezcla','premezcla_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }
}
