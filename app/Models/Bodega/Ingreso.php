<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\Bodega\PalletDetalle;
use App\Models\Bodega\IngresoDetalle;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Adquisicion\OrdenCompraDetalle;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $fillable = ['numero', 'descripcion', 'tipo_id', 'item_id', 'procesado', 'fecha_ing', 'user_id'];


    static function register($request) {

        $ingreso = DB::transaction(function() use($request) {

            $fecha = $request->fecha;
            $descripcion = $request->descripcion;
            $tipoIngreso = $request->tipo_ingreso;
            $tipoProd = $request->tipo_prod;
            $items = $request->items;
            $procesado = 0;
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
                'fecha_ing' => $fecha,
                'procesado' => $procesado,
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
                    'por_almacenar' => $item->cantidad,
                ]);

            };

            return $ingreso;

        });

        return $ingreso;
    }

    static function registerFromOC($request) {

        $ingreso = DB::transaction(function() use($request) {

            $ordenCompra = OrdenCompra::with('detalles')->where('id',$request->ordenCompra)->first();
            $statusIngresadaOC = config('globalVars.statusIngresadaOC');

            $fecha = $request->fecha;
            $descripcion = "Ingreso por Orden de compra numero ". $ordenCompra->numero;
            $tipoIngreso = $request->tipo_ingreso;
            $items = $request->items;
            $procesado = 0;
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
                'procesado' => $procesado,
                'user_id' => $usuario,
            ]);


            foreach ($items as $item) {

                $item = json_decode($item);

                IngresoDetalle::create([
                    'ing_id' => $ingreso->id,
                    'tipo_id' => $item->tipo_id,
                    'item_id' => $item->item_id,
                    'fecha_venc' => "2000-12-12",
                    'cantidad' => $item->recibidas,
                    'por_almacenar' => $item->recibidas,
                ]);

            };

            $ordenCompra->status_id = $statusIngresadaOC;
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
}
