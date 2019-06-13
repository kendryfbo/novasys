<?php

namespace App\Http\Controllers\Adquisicion;

use DB;
use PDF;
use Excel;
use App\Models\Insumo;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adquisicion\Proveedor;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Adquisicion\OrdenCompraDetalle;
use App\Models\Config\StatusDocumento;

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


    public function reportDetProveedorDownloadExcel(Request $request) {

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

          return Excel::create('Reporte Proveedores', function($excel) use ($ordenes, $proveedor) {
              $excel->sheet('New sheet', function($sheet) use ($ordenes, $proveedor) {
                  $sheet->loadView('documents.excel.reportOrdenCompraProveedorExcel')
                          ->with(['ordenes' => $ordenes,
                                  'proveedor' => $proveedor]);
                                  })->download('xlsx');
          });

      }



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

    public function reportInsumosDownloadExcel(Request $request) {

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

        return Excel::create('Reporte Insumo', function($excel) use ($ordenes) {
            $excel->sheet('New sheet', function($sheet) use ($ordenes) {
                $sheet->loadView('documents.excel.reportOrdenCompraInsumoExcel')
                        ->with('ordenes', $ordenes);
                            })->download('xlsx');
                        });


    }

    public function reporteProductos()
    {

        $productos = DB::table('orden_compra')
            ->join('orden_compra_detalles', 'orden_compra.id', '=', 'orden_compra_detalles.oc_id')
            ->join('proveedores', 'orden_compra.prov_id', '=', 'proveedores.id')
            ->join('areas', 'orden_compra.area_id', '=', 'areas.id')
            ->select('orden_compra.*', 'orden_compra_detalles.*', 'proveedores.descripcion as nombreProveedor', 'areas.descripcion as nombreArea')
            ->where('orden_compra_detalles.descripcion', 'like', '%BORDEN%')
            ->groupBy('nombreProveedor')
            ->get();


        return view('adquisicion.ordenCompra.reportProductos')->with(['productos' => $productos]);
    }

    public function excelReport()
    {

        $productos = DB::table('orden_compra')
            ->join('orden_compra_detalles', 'orden_compra.id', '=', 'orden_compra_detalles.oc_id')
            ->join('proveedores', 'orden_compra.prov_id', '=', 'proveedores.id')
            ->join('areas', 'orden_compra.area_id', '=', 'areas.id')
            ->select('orden_compra.*', 'orden_compra_detalles.*', 'proveedores.descripcion as nombreProveedor', 'areas.descripcion as nombreArea')
            ->where('orden_compra_detalles.descripcion', 'like', '%BORDEN%')
            ->groupBy('nombreProveedor')
            ->get();


        return Excel::create('Reporte O.C. BORDEN', function($excel) use ($productos) {
            $excel->sheet('New sheet', function($sheet) use ($productos) {
                $sheet->loadView('adquisicion.ordenCompra.reportExcelProductos')
                        ->with('productos', $productos);
                            })->download('xlsx');
                        });

    }

}
