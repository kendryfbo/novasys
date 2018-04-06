<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Nivel;
use App\Models\Formula;
use App\Models\FormulaDetalle;

class ProduccionPremezcla extends Model
{
    protected $table = 'produccion_premezcla';
    protected $fillable = ['numero','premezcla_id', 'user_id', 'cant_batch', 'fecha'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $premezclaID = $request->premezclaID;
            $nivelPremix = Nivel::premixID();
            $user = 1;    // fix user error $request->user()->id;
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
            ]);

            foreach ($insumosPremix as $insumoPremix) {

                $cantxbatch = $insumoPremix->cantxbatch * $cantBatch;

                ProdPremDetalle::create([
                    'prodprem_id' => $prodPremezcla->id,
                    'insumo_id' => $insumoPremix->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };

            return $prodPremezcla;
        },5);
    }

    // Relationships

    public function detalles() {


    return $this->hasMany('App\Models\Produccion\ProdPremDetalle', 'prodprem_id', 'id');
    }

    public function premezcla() {

        return $this->belongsTo('App\Models\Premezcla','premezcla_id');
    }
}
