<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
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

            $fecha = $request->fecha;
            $descripcion = $request->descripcion;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = $request->tipo_prod;
            $items = $request->items;
            $usuario = $request->user()->id;
            $status = StatusDocumento::pendienteID();

            $numero = Ingreso::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

    			$numero = 1;

    		} else {

    			$numero++;
    		};

            $ingreso = Ingreso::create([
                'numero' => $numero,
                'descripcion' => $descripcion,
                'tipo_id' => $tipoIngreso,
                'fecha_ing' => $fecha,
                'status_id' => $status,
                'user_id' => $usuario,
            ]);


            foreach ($items as $item) {

                $item = json_decode($item);

                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $tipoProd,
                    'item_id' => $item->id,
                    'fecha_venc' => $item->fecha_venc,
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
            $descripcion = "Ingreso por Orden de compra numero ". $ordenCompra->numero;
            $tipoIngreso = $request->tipo_ingreso;
            $items = $request->items;
            $status = StatusDocumento::pendienteID();
            $usuario = $request->user()->id;

            $numero = Ingreso::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {

    			$numero = 1;

    		} else {

    			$numero++;
    		};

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
                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'fecha_venc' => $item->fecha_venc,
                    'lote' => $item->num_lote,
                    'cantidad' => $item->cant_ing,
                    'por_procesar' => $item->cant_ing,
                ]);

            };

            $ordenCompra->updateStatus();
            $ordenCompra->save();

            return $ingreso;

        });

        return $ingreso;
    }

    static function getStockofProd($id) {

        return IngresoDetalle::where('item_id',$id)->sum('por_almacenar');
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
