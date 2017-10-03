<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Models\Producto;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\FacturaNacionalDetalle;

class ReportNacController extends Controller
{


    /*
     *  Reporte X Facturas Nacionales
     */
    public function reportFact(Request $request) {

        $busqueda = $request;
        $facturas = [];

        if ($request->all()) {

            $queryDates = [];
            $queryClientes = [];

            if ($request->desde) {

                $desde = ['fecha_emision', '>=', $request->desde];

                array_push($queryDates,$desde);
            };

            if ($request->hasta) {

                $hasta = ['fecha_emision', '<=', $request->hasta];

                array_push($queryDates,$hasta);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteNacional::where($queryClientes)->pluck('id');
            $facturas = FacturaNacional::whereIn('cliente_id',$clientes)->where($queryDates)->take(5000)->get();
        }

        $clientes = ClienteNacional::getAllActive();

        return view('comercial.reportesNac.indexFact')
                ->with([
                    'busqueda' => $busqueda,
                    'facturas' => $facturas,
                    'clientes' => $clientes
                ]);
    }

    // Reporte X Productos Facturas Nacionales
    public function reportProdFact(Request $request) {

        $busqueda = $request;
        $clientes = [];
        $detalles = [];

        if ($request->all()) {

            $desde = $request->desde;
            $hasta = $request->hasta;
            $cliente = $request->cliente;
            $producto = $request->producto;
            $group = $request->group;

            $queryDates = [];
            $queryClientes = [];
            $queryProductos = [];

            if ($desde) {

                $desde = ['fecha_emision', '>=', $deste];

                array_push($queryDates,$desde);
            };

            if ($hasta) {

                $hasta = ['fecha_emision', '<=', $hasta];

                array_push($queryDates,$hasta);
            };

            if ($cliente) {

                $cliente = ['id', '=', $cliente];

                array_push($queryClientes,$cliente);
            };

            if ($producto) {

                $producto = ['producto_id', '=', $producto];

                array_push($queryProductos,$producto);
            };

            $clientes = ClienteNacional::where($queryClientes)->pluck('id');
            $facturas = FacturaNacional::whereIn('cliente_id',$clientes)->where($queryDates)->pluck('id');

            if ($group) {

                $rawQuery = '(SELECT cliente FROM factura_nacional WHERE id=fact_nac_detalles.fact_id) as cliente,codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FacturaNacionalDetalle::groupBy('cliente','codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('fact_id',$facturas)
                ->where($queryProductos)
                ->get();

            } else {

                $rawQuery = 'codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';
                $detalles = FacturaNacionalDetalle::groupBy('codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('fact_id',$facturas)
                ->where($queryProductos)
                ->get();
            }



        }

        $clientes = ClienteNacional::getAllActive();
        $productos = Producto::getAllActive();

        return view('comercial.reportesNac.indexProd')
                ->with([
                    'busqueda' => $busqueda,
                    'detalles' => $detalles,
                    'clientes' => $clientes,
                    'productos' => $productos
                ]);
    }

    public function reportFactExcel(Request $request) {

        $facturas = [];

        if ($request->all()) {

            $queryDates = [];
            $queryClientes = [];

            if ($request->desde) {

                $desde = ['fecha_emision', '>=', $request->desde];

                array_push($queryDates,$desde);
            };

            if ($request->hasta) {

                $hasta = ['fecha_emision', '<=', $request->hasta];

                array_push($queryDates,$hasta);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteNacional::where($queryClientes)->pluck('id');
            $facturas = FacturaNacional::whereIn('cliente_id',$clientes)->where($queryDates)->take(5000)->get();
        }

        return Excel::create('Reporte X Facturas Nac', function($excel) use ($facturas) {
            $excel->sheet('New sheet', function($sheet) use ($facturas) {
                $sheet->loadView('documents.excel.reportNacFact')
                        ->with('facturas', $facturas);
                            })->download('xlsx');
        });
    }

    public function reportProdExcel(Request $request) {

        $clientes = [];
        $detalles = [];

        if ($request->all()) {

            $desde = $request->desde;
            $hasta = $request->hasta;
            $cliente = $request->cliente;
            $producto = $request->producto;
            $group = $request->group;

            $queryDates = [];
            $queryClientes = [];
            $queryProductos = [];

            if ($desde) {

                $desde = ['fecha_emision', '>=', $deste];

                array_push($queryDates,$desde);
            };

            if ($hasta) {

                $hasta = ['fecha_emision', '<=', $hasta];

                array_push($queryDates,$hasta);
            };

            if ($cliente) {

                $cliente = ['id', '=', $cliente];

                array_push($queryClientes,$cliente);
            };

            if ($producto) {

                $producto = ['producto_id', '=', $producto];

                array_push($queryProductos,$producto);
            };

            $clientes = ClienteNacional::where($queryClientes)->pluck('id');
            $facturas = FacturaNacional::whereIn('cliente_id',$clientes)->where($queryDates)->pluck('id');

            if ($group) {

                $rawQuery = '(SELECT cliente FROM factura_nacional WHERE id=fact_nac_detalles.fact_id) as cliente,codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FacturaNacionalDetalle::groupBy('cliente','codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('fact_id',$facturas)
                ->where($queryProductos)
                ->get();

            } else {

                $rawQuery = 'codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';
                $detalles = FacturaNacionalDetalle::groupBy('codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('fact_id',$facturas)
                ->where($queryProductos)
                ->get();
            }
        }

        return Excel::create('Reporte X producto Nac', function($excel) use ($detalles) {
            $excel->sheet('New sheet', function($sheet) use ($detalles) {
                $sheet->loadView('documents.excel.reportIntlProd')
                    ->with('detalles', $detalles);
                        })->download('xlsx');
        });
    }

}
