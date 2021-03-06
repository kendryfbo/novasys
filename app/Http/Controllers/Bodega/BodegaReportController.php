<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Models\Marca;
use App\Models\Sabor;
use App\Models\Formato;
use App\Models\Familia;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\Egreso;
use App\Models\Bodega\EgresoDetalle;

class BodegaReportController extends Controller
{
    public function indexBodegaReport(Request $request) {

        $busqueda = [];
        $productos = [];
        $bodegaID= null;
        $tipoID = null;
        $familiaID = null;
        $marcaID = null;
        $formatoID = null;
        $saborID = null;
        $bodegas = Bodega::getAllActive();
        $marcas= Marca::all(); // todas porque pueden haber marcas desactivadas con productos en stock;
        $sabores = Sabor::all(); // todas porque pueden haber Sabor desactivadas con productos en stock;
        $formatos = Formato::all(); // todas porque pueden haber Formato desactivadas con productos en stock;
        $familias = Familia::all(); // todas porque pueden haber Familias desactivadas con productos en stock;
        $tiposProducto = TipoFamilia::all(); // todas porque pueden haber Tipos de Familias desactivadas con productos en stock;

        if ($request->all()) {

            $bodegaID = $request->bodegaID;
            $tipoID = $request->tipoID;
            $familiaID = $request->familiaID;
            $marcaID = $request->marcaID;
            $saborID = $request->saborID;
            $formatoID = $request->formatoID;

            $datos = [
                'bodegaID' => $bodegaID,
                'tipoID' => $tipoID,
                'familiaID' => $familiaID,
                'marcaID' => $marcaID,
                'formatoID' => $formatoID,
                'saborID' => $saborID
            ];

            $productos = Bodega::getStockFromBodega($datos);
        }


        return view('bodega.bodega.reportBodega')
            ->with([
                'busqueda'  =>  $busqueda,
                'productos' => $productos,
                'bodegas'   => $bodegas,
                'tiposProducto'   => $tiposProducto,
                'marcas'    => $marcas,
                'marcaID'   => $marcaID,
                'familias'  => $familias,
                'familiaID' => $familiaID,
                'sabores' => $sabores,
                'saborID' => $saborID,
                'formatos' => $formatos,
                'formatoID' => $formatoID,
                'tipoID'      => $tipoID,
                'bodegaID'    => $bodegaID
            ]);
    }

    public function indexStockReport(Request $request) {

        $bodegaID = null;
        $tipoFamilia = null;
        $familiaID = null;
        $marcaID = null;
        $formatoID = null;
        $saborID = null;
        $tipoReporte = null;
        $productos = [];

        $tiposReporte = [
            ['id' => 0, 'descripcion' => 'total'],
            ['id' => 1, 'descripcion' => 'Ingreso'],
            ['id' => 2, 'descripcion' => 'Bodega'],
        ];
        $bodegas = Bodega::getAllActive();
        $tiposProducto = TipoFamilia::all(); // Todas ya que pueden haber productos con familia bloqueada en existencia;
        $familias = Familia::all(); // Todas ya que pueden haber productos con familia bloqueada en existencia;
        $marcas = Marca::all(); // Todas ya que pueden haber productos con familia bloqueada en existencia;
        $formatos = Formato::all(); // Todas ya que pueden haber productos con familia bloqueada en existencia;
        $sabores = Sabor::all(); // Todas ya que pueden haber productos con familia bloqueada en existencia;

        if ($request->all()) {

            $bodegaID = $request->bodegaID;
            $saborID = $request->saborID;
            $formatoID = $request->formatoID;
            $marcaID = $request->marcaID;
            $familiaID = $request->familiaID;
            $tipoFamilia = $request->tipoFamilia;
            $tipoReporte = $request->tipoReporte;

            $productos = Bodega::getStockTotal($tipoReporte,$bodegaID,$tipoFamilia,$familiaID,$marcaID,$formatoID,$saborID);
        }

        return view('bodega.bodega.reportStock')
            ->with([
                'productos' => $productos,
                'tipoReporte' =>  $tipoReporte,
                'bodegaID' => $bodegaID,
                'bodegas' => $bodegas,
                'tipoFamilia' => $tipoFamilia,
                'familiaID' => $familiaID,
                'familias' => $familias,
                'familiaID' => $familiaID,
                'marcas' => $marcas,
                'marcaID' => $marcaID,
                'formatos' => $formatos,
                'formatoID' => $formatoID,
                'sabores' => $sabores,
                'saborID' => $saborID,
                'tiposReporte' => $tiposReporte,
                'tiposProducto' => $tiposProducto
            ]);
    }

    /* DESCARGAR Reporte Bodega */
    public function downloadBodegaReportExcel(Request $request) {

        $busqueda = [];
        $productos = [];
        $bodegaID= null;
        $tipoID = null;
        $familiaID = null;
        $marcaID = null;
        $formatoID = null;
        $saborID = null;

        $bodegaID = $request->bodegaID;
        $tipoID = $request->tipoID;
        $familiaID = $request->familiaID;
        $marcaID = $request->marcaID;
        $saborID = $request->saborID;
        $formatoID = $request->formatoID;

        $datos = [
            'bodegaID' => $bodegaID,
            'tipoID' => $tipoID,
            'familiaID' => $familiaID,
            'marcaID' => $marcaID,
            'formatoID' => $formatoID,
            'saborID' => $saborID
        ];

        $productos = Bodega::getStockFromBodega($datos);

        return Excel::create('Reporte Stock Bodega', function($excel) use ($productos) {
            $excel->sheet('New sheet', function($sheet) use ($productos) {
                $sheet->loadView('documents.excel.reportBodega')
                        ->with('productos', $productos);
                            })->download('xlsx');
                        });
    }

    /* DESCARGAR Reporte Stock Total */
    public function donwloadStockTotalReportExcel(Request $request) {

        $bodegaID = $request->bodegaID;
        $saborID = $request->saborID;
        $formatoID = $request->formatoID;
        $marcaID = $request->marcaID;
        $familiaID = $request->familiaID;
        $tipoFamilia = $request->tipoFamilia;
        $tipoReporte = $request->tipoReporte;
        $productos = Bodega::getStockTotal($tipoReporte,$bodegaID,$tipoFamilia,$familiaID,$marcaID,$formatoID,$saborID);

        return Excel::create('Reporte Stock Total', function($excel) use ($productos) {
            $excel->sheet('New sheet', function($sheet) use ($productos) {
                $sheet->loadView('documents.excel.reportStockTotal')
                        ->with('productos', $productos);
                            })->download('xlsx');
                        });
    }

    public function indexBuscaLote(Request $request) {

      if (isset($request->loteNum)) {

        $buscaPallet = $request->loteNum;

        $palletEgresoDetalles = EgresoDetalle::where('lote',$buscaPallet)->get();


      } else {
        $palletEgresoDetalles = [];
      }

        return view('bodega.bodega.buscaLote')
            ->with(['palletEgresoDetalles' => $palletEgresoDetalles]);
    }



}
