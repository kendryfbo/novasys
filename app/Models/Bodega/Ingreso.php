<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use App\Models\TipoFamilia;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Config\StatusDocumento;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Adquisicion\OrdenCompraDetalle;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $fillable = ['numero', 'descripcion', 'tipo_id', 'item_id', 'status_id', 'fecha_ing', 'user_id'];

    static function register($request) {

        $ingreso = DB::transaction(function() use($request) {

            $fechaIng = $request->fecha;
            $descripcion = $request->descripcion;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = $request->tipo_prod;
            $items = $request->items;
            $usuario = $request->user()->id;
            $status = StatusDocumento::pendienteID();

            $numero = Ingreso::getNextNumber();

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'fecha_ing' => $fechaIng,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);


            foreach ($items as $item) {

                $item = json_decode($item);
                $fechaVenc = $item->fecha_venc ? $item->fecha_venc: null;
                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->id,
                    'fecha_ing' => $fechaIng,
                    'fecha_venc' =>  $fechaVenc,
                    'cantidad' => $item->cantidad,
                    'por_procesar' => $item->cantidad,
                ]);

            };

            return $ingreso;

        });

        return $ingreso;
    }

    static function registerFromOC($request) {

        $ingreso = DB::transaction(function() use($request) {

            $ordenCompra = OrdenCompra::with('detalles')->where('numero',$request->ordenCompra)->first();
            $statusIngresadaOC = StatusDocumento::ingresadaID();

            $fecha = $request->fecha;
            $descripcion = "Ingreso por Orden de compra Nº". $ordenCompra->numero;
            $tipoIngreso = $request->tipo_ingreso;
            $items = $request->items;
            $status = StatusDocumento::pendienteID();
            $usuario = $request->user()->id;

            $numero = Ingreso::getNextNumber();

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'item_id' => $ordenCompra->id,
                'fecha_ing' => $fecha,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);


            foreach ($items as $item) {

                $item = json_decode($item);

                if ($item->cant_ing <= 0) {
                    continue;
                }
                $detalle = OrdenCompraDetalle::find($item->id);
                $detalle->recibidas = $detalle->recibidas + $item->cant_ing;
                $detalle->save();
                $item->fecha_venc = $item->fecha_venc ? $item->fecha_venc:null;

                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'fecha_ing' => $fecha,
                    'fecha_venc' => $item->fecha_venc,
                    'lote' => $item->num_lote,
                    'cantidad' => $item->cant_ing,
                    'por_procesar' => $item->cant_ing,
                ]);

            };

            return $ingreso;

        });

        return $ingreso;
    }

    static function registerFromTermProc($terminoProceso) {

        DB::transaction(function() use($terminoProceso){

            $numero = Ingreso::getNextNumber();
            $descripcion = "Ingreso por Termino de Proceso Lote # ". $terminoProceso->lote;
            $tipoIngreso = IngresoTipo::termProcID();
            $fecha = $terminoProceso->fecha_prod;
            $status = StatusDocumento::pendienteID();
            $usuario = $terminoProceso->user_id;

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'item_id' => $terminoProceso->id,
                'fecha_ing' => $fecha,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);

            $id = $ingreso->id;
            $tipoProd = TipoFamilia::productoTerminado()->id;
            $productoID = $terminoProceso->prod_id;
            $fechaVenc = $terminoProceso->fecha_venc;
            $lote = $terminoProceso->lote;
            $cantidad = $terminoProceso->producidas;

            IngresoDetalle::create([
                'ing_id' => $id,
                'tipo_id' => $tipoProd,
                'item_id' => $productoID,
                'fecha_ing' => $fecha,
                'fecha_venc' => $fechaVenc,
                'lote' => $lote,
                'cantidad' => $cantidad,
                'por_procesar' => $cantidad,
            ]);

        });
    }

    static function registerFromProdPrem($prodPrem) {

        $ingreso = DB::transaction(function() use($prodPrem){

            $numero = Ingreso::getNextNumber();
            $descripcion = "Ingreso por Produccion de Premezcla # ". $prodPrem->id;
            $tipoIngreso = IngresoTipo::prodPremID();
            $fechaProd = $prodPrem->fecha_prod;
            $status = StatusDocumento::completaID();
            $usuario = $prodPrem->user_id;

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'item_id' => $prodPrem->id,
                'fecha_ing' => $fechaProd,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);

            $id = $ingreso->id;
            $tipoProd = TipoFamilia::getPremezclaID();
            $productoID = $prodPrem->formula->premezcla->id;
            $fechaVenc = $prodPrem->fecha_venc ? $prodPrem->fecha_venc : null;
            $lote = $prodPrem->lote;
            $cantidad = $prodPrem->cant_batch;

            IngresoDetalle::create([
                'ing_id' => $id,
                'tipo_id' => $tipoProd,
                'item_id' => $productoID,
                'fecha_ing' => $fechaProd,
                'fecha_venc' => $fechaVenc,
                'lote' => $lote,
                'cantidad' => $cantidad,
                'por_procesar' => $cantidad,
            ]);

            return $ingreso;
        },5);

        return $ingreso;
    }

    static function registerFromProdMez($prodMez) {

        $ingreso = DB::transaction(function() use($prodMez){

            $numero = Ingreso::getNextNumber();
            $descripcion = "Ingreso por Produccion de Mezclado # ". $prodMez->id;
            $tipoIngreso = IngresoTipo::prodMezID();
            $fechaProd = $prodMez->fecha_prod;
            $status = StatusDocumento::completaID();
            $usuario = $prodMez->user_id;

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'item_id' => $prodMez->id,
                'fecha_ing' => $fechaProd,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);

            $id = $ingreso->id;
            $tipoProd = TipoFamilia::getReprocesoID();
            $productoID = $prodMez->formula->reproceso->id;
            $detalle = $prodMez->formula->detalles;
            $fechaVenc = $prodMez->fecha_venc ? $prodMez->fecha_venc : null;
            $lote = $prodMez->lote;
            $cantidad = $prodMez->total_rpr;

            IngresoDetalle::create([
                'ing_id' => $id,
                'tipo_id' => $tipoProd,
                'item_id' => $productoID,
                'fecha_ing' => $fechaProd,
                'fecha_venc' => $fechaVenc,
                'lote' => $lote,
                'cantidad' => $cantidad,
                'por_procesar' => $cantidad,
            ]);

            return $ingreso;
        },5);

        return $ingreso;
    }

    static function getStockofProd($id = null) {

        $PT = config('globalVars.PT');

        if ($id) {
            return IngresoDetalle::where('tipo_id',$PT)->where('item_id',$id)->sum('por_procesar');

        } else {

            $table = (new IngresoDetalle)->getTable();
            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(por_procesar) as cantidad'))
            ->where('tipo_id',$PT)
            ->groupBy('item_id','tipo_id')
            ->get();
        }
    }

    static function getStockofPremezcla($id = null) {

        $PP = config('globalVars.PP');

        if ($id) {
            return IngresoDetalle::where('tipo_id',$PP)->where('item_id',$id)->sum('por_procesar');

        } else {

            $table = (new IngresoDetalle)->getTable();
            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(por_procesar) as cantidad'))
            ->where('tipo_id',$PP)
            ->groupBy('item_id','tipo_id')
            ->get();
        }
    }

    static function getStockofInsumo($id = null) {

        $MP = config('globalVars.MP');

        if ($id) {
            return IngresoDetalle::where('tipo_id',$MP)->where('item_id',$id)->sum('por_procesar');

        } else {

            $table = (new IngresoDetalle)->getTable();
            return DB::table($table)
            ->select('item_id','tipo_id',DB::raw('SUM(por_procesar) as cantidad'))
            ->where('tipo_id',$MP)
            ->groupBy('item_id','tipo_id')
            ->get();
        }
    }

    static function getNextNumber() {

        $numero = Ingreso::orderBy('numero','desc')->pluck('numero')->first();

        if (is_null($numero)) {

            $numero = 1;

        } else {

            $numero++;
        };
        return $numero;
    }

    static function descountItemFromIngreso($ingresoDetalleID,$cantidad) {

        $detalle = IngresoDetalle::with('ingreso')->find($ingresoDetalleID);
        $detalle->por_procesar = $detalle->por_procesar - $cantidad;
        $detalle->save();
        $detalle->ingreso->updateStatus();
        $detalle->ingreso->save();
    }
    /*
    |
    | Public Functions
    |
    */
    public function updateStatus() {

        $completa = true;
        $ingresada = false;

        foreach ($this->detalles as $detalle) {

            if ($detalle->por_procesar > 0) {
                $completa = false;
            }
            if ($detalle->por_procesar < $detalle->cantidad) {
                $ingresada = true;
            }
        }

        if ($completa) {
            $this->status_id = StatusDocumento::completaID();
        } else if($ingresada) {
            $this->status_id = StatusDocumento::ingresadaID();
        } else {
            $this->status_id = StatusDocumento::pendienteID();
        }
    }
    public function statusPendiente() {

        $pendiente = StatusDocumento::pendienteID();

        if ($this->status_id == $pendiente) {

            return true;
        }
        return false;
    }

    /*
    |
    | Public functions
    |
    */

    public function deleteIngOC() {

        DB::transaction( function() {

            $ordenCompra = OrdenCompra::with('detalles')->find($this->item_id);

            //si no encuentra orden de compra finaliza la ejecucion
            if (!$ordenCompra) {

                $this->delete();
                return;
            }

            foreach ($this->detalles as $detalleIngreso) {

                foreach ($ordenCompra->detalles as $detalleOC) {

                    if ($detalleIngreso->tipo_id == $detalleOC->tipo_id && $detalleIngreso->item_id == $detalleOC->item_id) {

                        $resta = $detalleOC->recibidas -  $detalleIngreso->cantidad;
                        $detalleOC->recibidas = $resta < 0 ? 0: $resta;
                        $detalleOC->save();
                        break;
                    }
                }
            }
            $ordenCompra->updateStatus();
            $this->delete();
        },5);
    }




    /*
    |
    | Relationships
    |
    */

    public function usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }

    public function tipo() {

        return $this->belongsTo('App\Models\Bodega\IngresoTipo','tipo_id');
    }

    public function detalles() {

        return $this->hasMany('App\Models\Bodega\IngresoDetalle','ing_id');
    }
    public function status() {

        return $this->belongsTo('App\Models\Config\StatusDocumento','status_id');
    }
}
