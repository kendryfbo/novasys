<?php

namespace App\Models\Produccion;

use DB;
use App\Models\Bodega\Ingreso;
use App\Models\Bodega\IngresoTipo;
use App\Models\Config\StatusDocumento;
use Illuminate\Database\Eloquent\Model;

class TerminoProceso extends Model
{
    protected $table = 'termino_proceso';

    protected $fillable = ['prod_id','turno','producidas','rechazadas', 'total',
                           'fecha_prod','fecha_venc','maquina','operador','cod',
                           'batch','lote', 'ingresadas', 'status_id', 'user_id'];


    /*
    |
    |     Statics Functions
    |
    */
    static function register($request) {

        $terminoProceso = DB::transaction(function() use($request){

            $user = $request->user()->id;

            $terminoProceso = Self::create([
                'prod_id' => $request->prod_id,
                'fecha_prod' => $request->fecha_prod,
                'fecha_venc' => $request->fecha_venc,
                'turno' => $request->turno,
                'producidas' => $request->producidas,
                'rechazadas' => $request->rechazadas,
                'total' => $request->producidas + $request->rechazadas,
                'maquina' => $request->maquina,
                'operador' => $request->operador,
                'batch' => $request->batch,
                'lote' => $request->lote,
                'ingresadas' => 0, // valor inicial, 0 unidades procesadas
                'status_id' => StatusDocumento::pendienteID(),
                'user_id' => $user,
            ]);
            $ingreso = Ingreso::registerFromTermProc($terminoProceso);

            return $terminoProceso;
        });

        return $terminoProceso;
    }

    static function remove($id) {

        $terminoProceso = DB::transaction(function() use($id){

            $terminoProceso = TerminoProceso::find($id);
            $tipo = IngresoTipo::termProcID();
            $status = StatusDocumento::pendienteID();

            if ($terminoProceso->status_id != $status) {

                return;
            }

            Ingreso::where('tipo_id',$tipo)->where('item_id',$id)->delete();

            $terminoProceso->delete();

            return $terminoProceso;
        });

        return $terminoProceso;
    }
    /*
    |
    |     Relationships
    |
    */
    public function producto() {

        return $this->belongsTo('App\Models\Producto','prod_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }

}
