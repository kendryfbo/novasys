<?php

namespace App\Models\Adquisicion;

use Illuminate\Database\Eloquent\Model;

use DB;
use Auth;
use App\Models\Nivel;
use App\Models\Producto;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Pallet;
use App\Models\Bodega\Ingreso;
use App\Models\Adquisicion\PlanProduccionDetalle;

class PlanProduccion extends Model {

    protected $fillable = ['descripcion', 'fecha_emision', 'user_id'];
    protected $table = 'plan_produccion';

    static function register($request) {

        $planProduccion = DB::transaction(function () use ($request) {

            $descripcion = $request->descripcion;
            $fechaEmision = $request->fecha_emision;
            $userID = $request->user()->id;
            $items = $request->items;

            $planProduccion = PlanProduccion::create([
              'descripcion' => $descripcion,
              'fecha_emision' => $fechaEmision,
              'user_id' => $userID
            ]);

            foreach ($items as $item) {

              $item = json_decode($item);
                PlanProduccionDetalle::create([
                  'plan_id' => $planProduccion->id,
                  'producto_id' => $item->id,
                  'cantidad' => $item->cantidad
                ]);

            };

        },5);

        return $planProduccion;
    }

    static function registerDuplicate($planProduccionOrig) {

        $planProduccion = DB::transaction(function () use ($planProduccionOrig) {

            $descripcion = $planProduccionOrig->descripcion;
            $fechaEmision = $planProduccionOrig->fecha_emision;
            $userID = Auth::id();
            $items = $planProduccionOrig->detalles;

            $planProduccion = PlanProduccion::create([
              'descripcion' => $descripcion,
              'fecha_emision' => $fechaEmision,
              'user_id' => $userID
            ]);

            foreach ($items as $item) {

                PlanProduccionDetalle::create([
                  'plan_id' => $planProduccion->id,
                  'producto_id' => $item->id,
                  'cantidad' => $item->cantidad
                ]);
            };

            return $planProduccion;
        },5);
        return $planProduccion;
    }

    static function analisisRequerimientosConStock($items){

        $mi_temporizador = microtime();
        $partes_de_la_hora_actual = explode(' ', $mi_temporizador);
        $hora_actual = $partes_de_la_hora_actual[1] + $partes_de_la_hora_actual[0];
        $hora_al_empezar = $hora_actual;


        $productos = [];
        $stockPremezclas = Bodega::getStockTotalPR();
        $stockMatPrima = Bodega::getStockTotalMP();

        foreach ($items as $item) {

            $producto = Producto::with('formula.detalle.insumo','formula.premezcla')->where('id',$item->producto_id)->first();

            $stockPallet = Pallet::getStockofProd($producto->id);
            $stockIngreso = Ingreso::getStockofProd($producto->id);
            $producto->cantidad = $item->cantidad;
            $producto->stock_bodega = $stockPallet;
            $producto->stock_ingreso = $stockIngreso;
            $producto->stock_total = $stockPallet + $stockIngreso;
            $cantidadRestante = $producto->cantidad - $producto->stock_total;
            $cantidadRestante = $cantidadRestante < 0 ? 0:$cantidadRestante;
            $producto->cant_restante = $cantidadRestante;
            $producto->premezcla = 0;
            $producto->stock_insumos = [];

            if ($producto->cant_restante > 0) {

                $premezcla = $producto->formula->premezcla;

                //if (!$premezcla) {
                if (true) {
                    $stockPremezcla = 0;
                } else {
                    foreach ($stockPremezclas as $stock) {

                        if ($premezcla->id == $stock->id) {
                            $stockPremezcla = $stock->total;
                        }
                    }
                }
                $arrayInsumos = [];
                $i=0;
                $formulaDetalle = $producto->formula->detalle;

                foreach ($formulaDetalle as $detalle) {

                    foreach ($stockMatPrima as $key => $matPrima) {

                        if ($detalle->insumo_id == $matPrima->id) {

                            if ($detalle->nivel_id == Nivel::premixID()) {

                                $requerido = ($detalle->cantxcaja * $producto->cant_restante) - ($detalle->cantxbatch * $stockPremezcla);
                            } else {
                                $requerido = $detalle->cantxcaja * $producto->cant_restante;
                            }

                            $arrayInsumos[$i] = [
                                'id' => $detalle->insumo_id,
                                'codigo' => $detalle->insumo->codigo,
                                'descripcion' => $detalle->insumo->descripcion,
                                'existencia' => $matPrima->total,
                                'requerida' => $requerido,
                                'faltante' => ($matPrima->total >= $requerido ? 0: $requerido-$matPrima->total)
                            ];

                            $stockMatPrima[$key]->requerida += $requerido;
                            $stockMatPrima[$key]->nivel_id = $detalle->nivel_id;
                            $i++;
                        }
                    }
                }
                $producto->stock_insumos = $arrayInsumos;
            }

            array_push($productos, $producto);
        }


        $mi_temporizador = microtime();
        $partes_de_la_hora_actual = explode(' ', $mi_temporizador);
        $hora_actual = $partes_de_la_hora_actual[1] + $partes_de_la_hora_actual[0];
        $hora_al_terminar = $hora_actual;
        $tiempo_total_en_segundos = round(($hora_al_terminar - $hora_al_empezar), 4);
        //dump('La pagina fue generada en '.$tiempo_total_en_segundos.' segundos.');

        return [$productos,$stockMatPrima];
    }

    //

    static function analisisRequerimientos($items){

        $mi_temporizador = microtime();
        $partes_de_la_hora_actual = explode(' ', $mi_temporizador);
        $hora_actual = $partes_de_la_hora_actual[1] + $partes_de_la_hora_actual[0];
        $hora_al_empezar = $hora_actual;


        $productos = [];
        $stockMatPrima = Bodega::getStockTotalMP();
        $stockPremezclas = Bodega::getStockTotalPR();

        foreach ($items as $item) {

            $producto = Producto::with('formula.detalle.insumo','formula.premezcla')->where('id',$item->producto_id)->first();
            $producto->cantidad = $item->cantidad;
            $producto->premezcla = 0;
            $producto->stock_insumos = [];
            if (!$producto->formula) {
                dd('Producto Sin Formula',$producto);
                break;
            }

            if ($producto->cantidad > 0) {

                $premezcla = $producto->formula->premezcla;

                //if (!$premezcla) {
                if (true) {
                    $stockPremezcla = 0;
                } else {
                    foreach ($stockPremezclas as $stock) {

                        if ($premezcla->id == $stock->id) {

                            $stockPremezcla = $stock->total;
                        }
                    }
                }
                $arrayInsumos = [];
                $i=0;
                $formulaDetalle = $producto->formula->detalle;

                foreach ($formulaDetalle as $detalle) {

                    foreach ($stockMatPrima as $key => $matPrima) {

                        if ($detalle->insumo_id == $matPrima->id) {

                            if ($detalle->nivel_id == Nivel::premixID()) {
                                $requerido = ($detalle->cantxcaja * $producto->cantidad) - ($detalle->cantxbatch * $stockPremezcla);

                            } else {
                                $requerido = $detalle->cantxcaja * $producto->cantidad;
                            }

                            $arrayInsumos[$i] = [
                                'id' => $detalle->insumo_id,
                                'codigo' => $detalle->insumo->codigo,
                                'descripcion' => $detalle->insumo->descripcion,
                                'existencia' => $matPrima->total,
                                'requerida' => $requerido,
                                'faltante' => ($matPrima->total >= $requerido ? 0: $requerido-$matPrima->total)
                            ];

                            $stockMatPrima[$key]->requerida += $requerido;
                            $stockMatPrima[$key]->nivel_id = $detalle->nivel_id;
                            $i++;
                        }
                    }
                }
                $producto->stock_insumos = $arrayInsumos;
            }

            array_push($productos, $producto);
        }


        $mi_temporizador = microtime();
        $partes_de_la_hora_actual = explode(' ', $mi_temporizador);
        $hora_actual = $partes_de_la_hora_actual[1] + $partes_de_la_hora_actual[0];
        $hora_al_terminar = $hora_actual;
        $tiempo_total_en_segundos = round(($hora_al_terminar - $hora_al_empezar), 4);
        //dump('La pagina fue generada en '.$tiempo_total_en_segundos.' segundos.');

        return [$productos,$stockMatPrima];
    }


    /*
    |
    |  Relationships
    |
    */

    public function detalles() {

        return $this->hasMany(PlanProduccionDetalle::class,'plan_id');
    }

    public function Usuario() {

        return $this->belongsTo('App\Models\Config\Usuario','user_id');
    }
}
