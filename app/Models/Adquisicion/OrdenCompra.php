<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

use App\Models\Comercial\Impuesto;
use DB;

class OrdenCompra extends Model
{
    protected $table = 'orden_compra';
    protected $fillable = ['numero', 'prov_id', 'area_id', 'contacto', 'forma_pago', 'nota',
    'fecha_emision', 'moneda', 'sub_total', 'descuento', 'neto', 'impuesto', 'total', 'status_id', 'tipo_id'];


    static function register($request) {

        $MP = config('globalVars.MP');
        $iva = Impuesto::getIva();
        $tiposOC = [
            'tipoOCBoleta' => config('globalVars.tipoOCBoleta'),
            'tipoOCHonorario' => config('globalVars.tipoOCHonorario'),
            'tipoOCFactura' => config('globalVars.tipoOCFactura'),
        ];

        $ordenCompra = DB::transaction(function() use($request,$MP,$iva,$tiposOC) {

            $numero = OrdenCompra::orderBy('numero','desc')->pluck('numero')->first();

            if (is_null($numero)) {
                $numero = 1;
            } else {
                $numero++;
            };

            $porcDesc = $request->porc_desc;
            $subTotal = 0;
            $descuento = 0;
            $neto = 0;
            $impuesto = 0;
            $total = 0;

            $ordenCompra = OrdenCompra::Create([

                'numero' => $numero,
                'prov_id' => $request->prov_id,
                'area_id' => $request->area_id,
                'contacto' => $request->contacto,
                'forma_pago' => $request->forma_pago,
                'nota' => $request->nota,
                'fecha_emision' => $request->fecha_emision,
                'moneda' => $request->moneda,
                'sub_total' => 0,
                'descuento' => 0,
                'neto' => 0,
                'impuesto' => 0,
                'total' => 0,
                'status_id' => 1,
                'tipo_id' => $request->tipo,
            ]);

            foreach ($request->items as $item) {

                $item = json_decode($item);

                $cantidad = $item->cantidad;
                $precio = $item->precio;
                $subTotalItem = $cantidad * $precio;

                OrdenCompraDetalle::create([
                    'oc_id' => $ordenCompra->id,
                    'tipo_id' => $MP,
                    'item_id' => $item->id,
                    'codigo' => $item->codigo,
                    'descripcion' => $item->descripcion,
                    'unidad' => $item->umed,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'sub_total' => $subTotalItem,
                    'recibidas' => 0
                ]);

                $subTotal += $subTotalItem;
            };

            $descuento = ($subTotal * $porcDesc) / 100;

            if ($ordenCompra->tipo_id == $tiposOC["tipoOCBoleta"]) {

                $neto = $subTotal - $descuento;
                $impuesto = 0;
                $total = $neto + $impuesto;

            } else if ($ordenCompra->tipo_id == $tiposOC["tipoOCHonorario"]) {

                $total = $neto - $descuento;
                $neto = $total / 0.9;
                $impuesto = $neto * 0.1;

            } else {

                $neto = $subTotal - $descuento;
                $impuesto = ($neto * $iva->valor) / 100;
                $total = $neto + $impuesto;
            }

            $ordenCompra->sub_total = $subTotal;
            $ordenCompra->descuento = $descuento;
            $ordenCompra->neto = $neto;
            $ordenCompra->impuesto = $impuesto;
            $ordenCompra->total = $total;

            $ordenCompra->save();

            return $ordenCompra;
        },5);

        return $ordenCompra;
    }

    static function registerEdit($request,$ordenCompra) {

        $MP = config('globalVars.MP');
        $iva = Impuesto::getIva();
        $tiposOC = [
            'tipoOCBoleta' => config('globalVars.tipoOCBoleta'),
            'tipoOCHonorario' => config('globalVars.tipoOCHonorario'),
            'tipoOCFactura' => config('globalVars.tipoOCFactura'),
        ];

        $ordenCompra = DB::transaction(function() use($request,$ordenCompra,$MP,$iva,$tiposOC) {


            $porcDesc = $request->porc_desc;
            dd($porcDesc);
            $subTotal = 0;
            $descuento = 0;
            $neto = 0;
            $impuesto = 0;
            $total = 0;

            $ordenCompra->prov_id = $request->prov_id;
            $ordenCompra->area_id = $request->area_id;
            $ordenCompra->contacto = $request->contacto;
            $ordenCompra->forma_pago = $request->forma_pago;
            $ordenCompra->nota = $request->nota;
            $ordenCompra->fecha_emision = $request->fecha_emision;
            $ordenCompra->moneda = $request->moneda;
            $ordenCompra->sub_total = 0;
            $ordenCompra->descuento = 0;
            $ordenCompra->neto = 0;
            $ordenCompra->impuesto = 0;
            $ordenCompra->total = 0;
            $ordenCompra->status_id = 1;
            $ordenCompra->tipo_id = $request->tipo;
            $ordenCompra->aut_contab = NULL;

            OrdenCompraDetalle::where('oc_id',$ordenCompra->id)->delete();

            foreach ($request->items as $item) {

                $item = json_decode($item);

                $cantidad = $item->cantidad;
                $precio = $item->precio;
                $subTotalItem = $cantidad * $precio;

                OrdenCompraDetalle::create([
                    'oc_id' => $ordenCompra->id,
                    'tipo_id' => $MP,
                    'item_id' => $item->id,
                    'codigo' => $item->codigo,
                    'descripcion' => $item->descripcion,
                    'unidad' => $item->unidad,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'sub_total' => $subTotalItem,
                    'recibidas' => 0
                ]);

                $subTotal += $subTotalItem;
            };

            $descuento = ($subTotal * $porcDesc) / 100;

            if ($ordenCompra->tipo_id == $tiposOC["tipoOCBoleta"]) {

                $neto = $subTotal - $descuento;
                $impuesto = 0;
                $total = $neto + $impuesto;

            } else if ($ordenCompra->tipo_id == $tiposOC["tipoOCHonorario"]) {

                $total = $neto - $descuento;
                $neto = $total / 0.9;
                $impuesto = $neto * 0.1;

            } else {

                $neto = $subTotal - $descuento;
                $impuesto = ($neto * $iva->valor) / 100;
                $total = $neto + $impuesto;
            }

            $ordenCompra->sub_total = $subTotal;
            $ordenCompra->descuento = $descuento;
            $ordenCompra->neto = $neto;
            $ordenCompra->impuesto = $impuesto;
            $ordenCompra->total = $total;

            $ordenCompra->save();

            return $ordenCompra;
        },5);

        return $ordenCompra;
    }

    /*
    | public functions
    */
    public function authorizeContab() {

        $this->aut_contab = 1;
        $this->save();
    }

    public function unauthorizeContab() {

        $this->aut_contab = 0;
        $this->save();
    }
    public function complete() {

        $this->status_id = 3; // importar desde global vars o tabla orden_compra_status
        $this->save();
    }
    public function incomplete() {

        $this->status_id = 1; // importar desde global vars o tabla orden_compra_status
        $this->save();
    }
    /*
    | Relations
    */
    public function detalles() {

        return $this->hasMany('App\Models\Adquisicion\OrdenCompraDetalle','oc_id');
    }
    public function proveedor() {

        return $this->belongsTo('App\Models\Adquisicion\Proveedor','prov_id');
    }

    public function area() {

        return $this->belongsTo('App\Models\Adquisicion\Area','area_id');
    }

    public function status() {

        return $this->belongsTo('App\Models\Adquisicion\OrdenCompraStatus','status_id');
    }

    public function tipo() {

        return $this->belongsTo('App\Models\Adquisicion\OrdenCompraTipo','tipo_id');
    }

}
