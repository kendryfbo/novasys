<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;
use App\Models\Config\StatusDocumento;

class OrdenEgreso extends Model
{
    protected $table = 'orden_egreso';

    protected $fillable = ['numero', 'tipo_doc', 'doc_id', 'fecha_gen', 'user_id'];


    static function generate($user,$tipo,$id,$bodega = null) {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');
        $documento = [];
        $tipoDoc = '';
        if ($tipo == $tipoProforma) {

            $documento = Proforma::with('detalles')->find($id);
            $tipoDoc = $tipoProforma;


        } else if ($tipo == $tipoNotaVenta) {

            $documento = NotaVenta::with('detalles')->find($id);
            $tipoDoc = $tipoNotaVenta;
        }

        if ($documento->status != StatusDocumento::pendienteID()) {
            dd('ERROR - Ya este documento fue Generado',$documento->attributes);
        };

        $ordenEgreso = DB::transaction(function() use($bodega,$documento,$user,$tipoDoc){

            $tipoProducto = config('globalVars.PT');
            $fecha = Carbon::now()->format('Y-m-d');
            $numero = OrdenEgreso::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

                $numero = 1;

            } else {

                $numero++;
            };

            $ordenEgreso = OrdenEgreso::create([
                'numero' => $numero,
                'tipo_doc' => $tipoDoc,
                'doc_id' => $documento->id,
                'fecha_gen' => $fecha,
                'user_id' => $user,
            ]);

            foreach ($documento->detalles as $detalle) {

                $cantidad = $detalle->cantidad;

                while ($cantidad > 0) {

                    $restar = 0;

                    $posicion = Posicion::getPositionThatContainItem($bodega,$tipoProducto,$detalle->producto_id);

                    if (!$posicion) {

                        dd('Error al generar orden de Egreso - No existencia');
                    }

                    if ($cantidad > $posicion->existencia) {

                        $restar = $posicion->existencia;

                    } else {

                        $restar = $cantidad;
                    }

                    $cantidad = $cantidad - $restar;

                    $posicion->subtract($posicion->detalle_id,$restar);

                    $ordenEgresoDetalle = OrdenEgresoDetalle::create([
                        'orden_id' => $ordenEgreso->id,
                        'tipo_id' => $tipoProducto,
                        'item_id' => $detalle->producto_id,
                        'bodega' => $posicion->bodega->descripcion,
                        'posicion' => $posicion->format(),
                        'cantidad' => $restar,
                    ]);
                }
            }

            $documento->status = StatusDocumento::completaID();
            $documento->save();

            return $ordenEgreso;
        });

        return $ordenEgreso;
    }

    /*
    |     Relations
    */
    public function documento() {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        if ($this->tipo_doc == $tipoProforma) {

            $this->tipo_descrip = 'Proforma';
            return $this->belongsTo('App\Models\Comercial\Proforma','doc_id');

        } elseif ($this->tipo_doc == $tipoNotaVenta) {

            $this->tipo_descrip = 'NotaVenta';
            return $this->belongsTo('App\Models\Comercial\NotaVenta','doc_id');
        }

        return;
    }

    public function detalles() {

        return $this->hasMany('App\Models\Bodega\OrdenEgresoDetalle','orden_id');
    }

    // Esto debe ser sustituido por la relacion a tabla tipo_documento.
    public function tipo() {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        if ($this->tipo_doc == $tipoProforma) {

            $this->tipo_descrip = 'Proforma';
        } else if ($this->tipo_doc == $tipoNotaVenta) {

            $this->tipo_descrip = 'Nota Venta';
        } else {

            $this->tipo_descrip = 'DESCONOCIDO';
        }
    }
}
