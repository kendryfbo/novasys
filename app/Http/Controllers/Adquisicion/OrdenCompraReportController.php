<?php

namespace App\Http\Controllers\Adquisicion;

use PDF;
use App\Models\Insumo;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adquisicion\Proveedor;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Adquisicion\OrdenCompraDetalle;

class OrdenCompraReportController extends Controller
{
    public function reportProveedor(Request $request) {

        $busqueda = $request;
        $ordenes = [];

        $query = [];

        if ($busqueda->desde) {

            $desde = ['fecha_emision', '>=', $busqueda->desde];
            array_push($query,$desde);
        }
        if ($busqueda->hasta) {

            $hasta = ['fecha_emision', '<=', $busqueda->hasta];
            array_push($query,$hasta);
        }
        if ($busqueda->proveedor_id) {

            $proveedor = ['prov_id','=',$busqueda->proveedor_id];

            array_push($query,$proveedor);
            $ordenes = OrdenCompra::where($query)->orderBy('fecha_emision','DESC')->get();
        }

        $proveedores = Proveedor::has('ordenCompras')->get();


        return view('adquisicion.ordenCompraReport.reportProveedor')->with([
            'busqueda' => $busqueda,
            'ordenes' => $ordenes,
            'proveedores' => $proveedores,
        ]);
    }

    public function reportInsumos(Request $request) {

        $busqueda = $request;
        $insumoID = $busqueda->insumo_id;
        $ordenes = [];

        if ($insumoID) {

            $ordenes = OrdenCompra::with(['detalles' => function($query) use($insumoID){
                                        $query->where('item_id',$insumoID);
                                        $query->with('insumo');
                                    }],'detalles.insumo','proveedor')
                                    ->whereHas('detalles' ,function($query) use($insumoID){
                                        $query->where('item_id',$insumoID);
                                    })
                                    ->get();
        }

        $insumos = Insumo::has('OrdenCompraDetalle')->get();

        return view('adquisicion.ordenCompraReport.reportInsumo')->with([
            'busqueda' => $busqueda,
            'insumos' => $insumos,
            'ordenes' => $ordenes,
        ]);

    }

    public function reportProveedorDownloadPDF(Request $request) {

        $busqueda = $request;
        $ordenes = [];

        $query = [];

        if ($busqueda->desde) {

            $desde = ['fecha_emision', '>=', $busqueda->desde];
            array_push($query,$desde);
        }
        if ($busqueda->hasta) {

            $hasta = ['fecha_emision', '<=', $busqueda->hasta];
            array_push($query,$hasta);
        }

        if ($busqueda->proveedor_id) {

            $proveedor = ['prov_id','=',$busqueda->proveedor_id];

            array_push($query,$proveedor);

            $ordenes = OrdenCompra::where($query)->orderBy('fecha_emision','ASC')->get();
            $proveedor = Proveedor::find($busqueda->proveedor_id);

            $pdf = PDF::loadView('documents.pdf.reportOrdenCompraProveedorPDF',compact('ordenes','proveedor'));
            return $pdf->stream('Ordenes de Compra Pendientes.pdf');
        }

        return redirect()->back();
    }

    public function reportDetProveedorDownloadPDF(Request $request) {

        $busqueda = $request;
        $ordenes = [];

        $query = [];

        if ($busqueda->desde) {

            $desde = ['fecha_emision', '>=', $busqueda->desde];
            array_push($query,$desde);
        }
        if ($busqueda->hasta) {

            $hasta = ['fecha_emision', '<=', $busqueda->hasta];
            array_push($query,$hasta);
        }

        if ($busqueda->proveedor_id) {

            $proveedor = ['prov_id','=',$busqueda->proveedor_id];

            array_push($query,$proveedor);

            $ordenes = OrdenCompra::with('detalles')->where($query)->orderBy('fecha_emision','ASC')->get();
            $proveedor = Proveedor::find($busqueda->proveedor_id);

            $pdf = PDF::loadView('documents.pdf.reportDetOrdenCompraProveedorPDF',compact('ordenes','proveedor'));
            return $pdf->stream('Ordenes de Compra Pendientes.pdf');
        }

        return redirect()->back();
    }

    public function reportInsumosDownloadPDF(Request $request) {

        $busqueda = $request;
        $insumoID = $busqueda->insumo_id;
        $ordenes = [];

        if ($insumoID) {

            $ordenes = OrdenCompra::with(['detalles' => function($query) use($insumoID){
                                        $query->where('item_id',$insumoID);
                                        $query->with('insumo');
                                    }],'detalles.insumo','proveedor')
                                    ->whereHas('detalles' ,function($query) use($insumoID){
                                        $query->where('item_id',$insumoID);
                                    })
                                    ->get();
        }

        $pdf = PDF::loadView('documents.pdf.reportOrdenCompraInsumoPDF',compact('ordenes'));
        return $pdf->stream('Reporte Insumo - Orden Compra.pdf');


    }
}
