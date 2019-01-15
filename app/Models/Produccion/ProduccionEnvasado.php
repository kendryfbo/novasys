<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Reproceso;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\FormulaDetalle;
use App\Models\Bodega\IngresoTipo;
use App\Models\Config\StatusDocumento;
use App\Models\Produccion\ProdEnvDetalle;

class ProduccionEnvasado extends Model
{
    protected $table = 'produccion_envasado';
    protected $fillable = ['numero','formula_id', 'user_id', 'cant_batch', 'fecha_prod', 'fecha_venc', 'status_id'];

    static function register($request) {

        return DB::transaction(function() use($request){

            $formulaID = $request->formulaID;
            $cantBatch = $request->cantBatch;
            $productoID = $request->productoID;
            $nivelPremix = $request->nivelID;
            $fechaProd = $request->fecha_prod;
            $fechaVenc = $request->fecha_prod;
            $user = $request->user()->id;
            $status = StatusDocumento::pendienteID();

            $insumosPremix = FormulaDetalle::where('formula_id',$formulaID)
                ->where('nivel_id',$nivelPremix)->get();

            $numero = ProduccionEnvasado::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {
    			$numero = 1;
    		} else {
    			$numero++;
    		};
            $prodEnvasado = ProduccionEnvasado::create([
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

                ProdEnvDetalle::create([
                    'prodenv_id' => $prodEnvasado->id,
                    'insumo_id' => $insumoPremix->insumo_id,
                    'cantidad' => $cantxbatch,
                ]);
            };

            return $prodEnvasado;
        },5);
    }

    static function processEnvasado($prodEnvID,$bodegaID) {

        $prodEnv = ProduccionEnvasado::with('detalles')->where('id',$prodEnvID)->first();
        $pendiente = StatusDocumento::pendienteID();

        if($prodEnv->status_id != $pendiente) {

            dd('ERROR - Produccion de Envasado ya ha sido Procesada');
        }

        $prodEnv = DB::transaction( function() use($prodEnv,$bodegaID) {

            $tipoProd = TipoFamilia::getInsumoID();
            $tipoIngreso = IngresoTipo::prodEnvID();

            foreach ($prodEnv->detalles as $detalle) {

                $itemID = $detalle->insumo_id;
                $cantidad = $detalle->cantidad;

                $posiciones = Bodega::descount($bodegaID,$tipoProd,$itemID,$cantidad);
            }
            // buscar ingreso
            //$ingreso = Ingreso::where('tipo_id',$tipoIngreso)->where('item_id',$prodEnv->id)->first();
            // generar Pallet
            //$pallet = Pallet::storeFromIngreso($ingreso->id);
            // Buscar Posicion para Pallet
            //$bodegaEnv = Bodega::getBodEnvasadoID(); // Reproceso se almacena en bodega Envasado automaticamente
            //$posicion = Posicion::findPositionForPallet($bodegaEnv,$pallet->id);
            // Ingresar pallet a Bodega
            //Bodega::storePalletInPosition($posicion->id,$pallet->id);
            // actualizar status
            $prodEnv->status_id = StatusDocumento::completaID();
            $prodEnv->save();

            return $prodEnv;
        },5);

        return $prodEnv;
    }

    static function remove($id) {

        $prodEnvasado = DB::transaction(function() use($id){

            $prodEnvasado = ProduccionEnvasado::find($id);
            $tipo = IngresoTipo::prodEnvID();
            $status = StatusDocumento::pendienteID();

            if ($prodEnvasado->status_id != $status) {

                return;
            }

            $prodEnvasado->delete();

            return $prodEnvasado;
        },5);

        return $prodEnvasado;
    }

    /*
    |
    | Relationships
    |
    */
    public function detalles() {

        return $this->hasMany('App\Models\Produccion\ProdEnvDetalle', 'prodenv_id');
    }

    public function formula() {

        return $this->belongsTo('App\Models\formula','formula_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }
}
