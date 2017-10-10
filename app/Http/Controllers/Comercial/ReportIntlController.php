<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Models\Producto;
use App\Models\Comercial\Pais;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\ProformaDetalle;
use App\Models\Comercial\FactIntlDetalle;

class ReportIntlController extends Controller
{

    /*
    *   REPORTE FACTURAS INTERNACIONALES
    **/
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

            if ($request->pais) {

                $pais = ['pais', '=', $request->pais];

                array_push($queryClientes,$pais);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->take(5000)->get();
        }

        $paises = Pais::getAllActive();
        $clientes = ClienteIntl::getAllActive();

        return view('comercial.reportesIntl.reportFactIntl')
                ->with([
                    'busqueda' => $busqueda,
                    'facturas' => $facturas,
                    'paises' => $paises,
                    'clientes' => $clientes
                ]);
    }

    /*
    *   REPORTE FACTURAS INTERNACIONALES POR PRODUCTOS
    **/
    public function reportProdFact(Request $request) {

        $busqueda = $request;
        $detalles = [];

        if ($request->all()) {

            $deste = $request->desde;
            $hasta = $request->hasta;
            $pais = $request->pais;
            $cliente = $request->cliente;
            $producto = $request->producto;
            $group = $request->group;

            $queryDates = [];
            $queryClientes = [];
            $queryProductos = [];

            if ($request->desde) {

                $desde = ['fecha_emision', '>=', $request->desde];

                array_push($queryDates,$desde);
            };

            if ($request->hasta) {

                $hasta = ['fecha_emision', '<=', $request->hasta];

                array_push($queryDates,$hasta);
            };

            if ($request->pais) {

                $pais = ['pais', '=', $request->pais];

                array_push($queryClientes,$pais);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            if ($request->producto) {

                $producto = ['producto_id', '=', $request->producto];

                array_push($queryProductos,$producto);
            };


            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->pluck('id');

            if ($group) {

                $rawQuery = '(SELECT cliente FROM factura_intl WHERE id=fact_intl_detalles.factura_id) as cliente
                                ,codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FactIntlDetalle::groupBy('cliente','codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('factura_id',$facturas)
                ->where($queryProductos)
                ->get();

            } else {

                $rawQuery = 'codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FactIntlDetalle::groupBy('codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('factura_id',$facturas)
                ->where($queryProductos)
                ->get();
            }

        }

        $paises = Pais::getAllActive();
        $clientes = ClienteIntl::getAllActive();
        $productos = Producto::getAllActive();

        return view('comercial.reportesIntl.reportProdFactIntl')
                ->with([
                    'busqueda' => $busqueda,
                    'detalles' => $detalles,
                    'paises' => $paises,
                    'clientes' => $clientes,
                    'productos' => $productos
                ]);
    }


    /* DESCARGAR Reporte X Factura */
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

            if ($request->pais) {

                $pais = ['pais', '=', $request->pais];

                array_push($queryClientes,$pais);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->take(5000)->get();

        }

        return Excel::create('Reporte X Facturas Intl', function($excel) use ($facturas) {
            $excel->sheet('New sheet', function($sheet) use ($facturas) {
                $sheet->loadView('documents.excel.reportIntlFact')
                        ->with('facturas', $facturas);
                            })->download('xlsx');
                        });
    }

    /* DESCARGAR Reporte X Producto */
    public function reportProdExcel(Request $request) {

        $detalles = [];

        if ($request->all()) {

            $deste = $request->desde;
            $hasta = $request->hasta;
            $pais = $request->pais;
            $cliente = $request->cliente;
            $producto = $request->producto;
            $group = $request->group;

            $queryDates = [];
            $queryClientes = [];
            $queryProductos = [];

            if ($request->desde) {

                $desde = ['fecha_emision', '>=', $request->desde];

                array_push($queryDates,$desde);
            };

            if ($request->hasta) {

                $hasta = ['fecha_emision', '<=', $request->hasta];

                array_push($queryDates,$hasta);
            };

            if ($request->pais) {

                $pais = ['pais', '=', $request->pais];

                array_push($queryClientes,$pais);
            };

            if ($request->cliente) {

                $cliente = ['id', '=', $request->cliente];

                array_push($queryClientes,$cliente);
            };

            if ($request->producto) {

                $producto = ['producto_id', '=', $request->producto];

                array_push($queryProductos,$producto);
            };


            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->pluck('id');

            if ($group) {

                $rawQuery = '(SELECT cliente FROM factura_intl WHERE id=fact_intl_detalles.factura_id) as cliente
                                ,codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FactIntlDetalle::groupBy('cliente','codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('factura_id',$facturas)
                ->where($queryProductos)
                ->get();

            } else {

                $rawQuery = 'codigo,descripcion,SUM(cantidad) as cantidad, MAX(precio) as precio, SUM(cantidad*precio) as total';

                $detalles = FactIntlDetalle::groupBy('codigo','descripcion')
                ->selectRaw($rawQuery)
                ->whereIn('factura_id',$facturas)
                ->where($queryProductos)
                ->get();
            }

        }

        return Excel::create('Reporte X producto Intl', function($excel) use ($detalles) {
            $excel->sheet('New sheet', function($sheet) use ($detalles) {
                $sheet->loadView('documents.excel.reportIntlProd')
                    ->with('detalles', $detalles);
                        })->download('xlsx');
        });
    }

}
