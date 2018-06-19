<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use App\Models\TipoFamilia;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;
use App\Models\Config\TipoDocumento;
use App\Models\Bodega\EgresoDetalle;
use App\Models\Config\StatusDocumento;

class Egreso extends Model
{
    protected $table = 'egreso';
    protected $fillable = ['numero', 'descripcion', 'tipo_id', 'item_id', 'item_num', 'fecha_egr', 'status_id', 'user_id'];

    /*
    |
    |   Static Functions
    |
    */
    // Generar Egreso de Bodega
    static function register($request) {

        $egreso = DB::transaction(function() use($request){

            $bodega = $request->bodega_id;
            $tipoEgreso = $request->tipo_egreso;
            $descripcion = $request->descripcion;
            $tipoProducto = $request->tipo_prod;
            $user = $request->user()->id;
            $status = StatusDocumento::pendienteID();
            $fecha = Carbon::now()->format('Y-m-d');

            $numero = Egreso::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

                $numero = 1;

            } else {

                $numero++;
            };

            $egreso = Egreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoEgreso,
                'item_id' => null,
                'item_num' => null,
                'fecha_egr' => $fecha,
                'user_id' => $user,
                'status_id' => $status,
            ]);

            foreach ($request->items as $detalle) {

                $detalle = json_decode($detalle);
                $cantidad = $detalle->cantidad;

                while ($cantidad > 0) {

                    $restar = 0;

                    $posicion = Posicion::getPositionThatContainItem($bodega,$tipoProducto,$detalle->id);

                    if (!$posicion) {

                        dd('Error al generar Egreso - No existencia');
                    }

                    if ($cantidad > $posicion->existencia) {

                        $restar = $posicion->existencia;

                    } else {

                        $restar = $cantidad;
                    }

                    $cantidad = $cantidad - $restar;

                    $posicion->subtract($posicion->detalle_id,$restar);

                    $egresoDetalle = EgresoDetalle::create([
                        'egr_id' => $egreso->id,
                        'tipo_id' => $tipoProducto,
                        'item_id' => $detalle->id,
                        'bodega' => $posicion->bodega->descripcion,
                        'posicion' => $posicion->format(),
                        'fecha_egr' => $egreso->fecha_egr,
                        'cantidad' => $restar,
                    ]);
                }
            }
            $status = StatusDocumento::completaID();
            $egreso->status_id = $status;
            $egreso->save();

            return $egreso;
        });

        return $egreso;
    }
    // Generar Egreso atravez de Proforma o Nota de Venta
    static function generate($user,$tipo,$id,$bodega = null) {

        $tipoProforma  = TipoDocumento::proformaID();
        $tipoNotaVenta = TipoDocumento::notaVentaID();

        $documento = [];
        $tipoEgreso = '';
        $descripcion = '';
        if ($tipo == $tipoProforma) {

            $documento = Proforma::with('detalles')->find($id);
            $descripcion = 'Egreso Orden Egreso - Proforma # '. $documento->numero;
            $tipoEgreso = EgresoTipo::profID();


        } else if ($tipo == $tipoNotaVenta) {

            $documento = NotaVenta::with('detalles')->find($id);
            $descripcion = 'Egreso Orden Egreso - Nota Venta # '. $documento->numero;
            $tipoEgreso = EgresoTipo::nvID();
        }

        if ($documento->status != StatusDocumento::pendienteID()) {
            dd('ERROR - Ya este documento fue Generado',$documento->attributes);
        };

        $egreso = DB::transaction(function() use($bodega,$documento,$user,$tipoEgreso,$descripcion){

            $tipoProducto = TipoFamilia::getProdTermID();
            $status = StatusDocumento::pendienteID();
            $fecha = Carbon::now()->format('Y-m-d');
            $numero = Egreso::orderBy('numero','desc')->pluck('numero')->first();
            if (is_null($numero)) {

                $numero = 1;

            } else {

                $numero++;
            };

            $egreso = Egreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoEgreso,
                'item_id' => $documento->id,
                'item_num' => $documento->numero,
                'fecha_egr' => $fecha,
                'user_id' => $user,
                'status_id' => $status,
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

                    $egresoDetalle = EgresoDetalle::create([
                        'egr_id' => $egreso->id,
                        'tipo_id' => $tipoProducto,
                        'item_id' => $detalle->producto_id,
                        'bodega' => $posicion->bodega->descripcion,
                        'posicion' => $posicion->format(),
                        'fecha_egr' => $egreso->fecha_egr,
                        'cantidad' => $restar,
                    ]);
                }
            }
            $status = StatusDocumento::completaID();
            $documento->status = $status;
            $egreso->status_id = $status;
            $egreso->save();
            $documento->save();

            return $egreso;
        });

        return $egreso;
    }


    /*
    |
    |   Relationships
    |
    */

    public function usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }

    public function tipo() {

        return $this->belongsTo('App\Models\Bodega\EgresoTipo','tipo_id');
    }

    public function detalles() {

        return $this->hasMany('App\Models\Bodega\EgresoDetalle','egr_id');
    }
    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }

    public function documento() {

        $tipoProforma  = EgresoTipo::profID();
        $tipoNotaVenta = EgresoTipo::nvID();

        if ($this->tipo_id == $tipoProforma) {

            $this->tipo_descrip = 'Proforma';
            return $this->belongsTo('App\Models\Comercial\Proforma','item_id');

        } elseif ($this->tipo_doc == $tipoNotaVenta) {

            $this->tipo_descrip = 'NotaVenta';
            return $this->belongsTo('App\Models\Comercial\NotaVenta','item_id');
        }
        // si es de otro tipo retornara NULL ya que item_id es NULL
        return $this->belongsTo('App\Models\Comercial\NotaVenta','null');

    }
}