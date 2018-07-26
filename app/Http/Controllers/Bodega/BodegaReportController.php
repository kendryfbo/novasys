<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Models\Marca;
use App\Models\Familia;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;

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
        $familias = Familia::all(); // todas porque pueden haber Familias desactivadas con productos en stock;
        $tiposProducto = TipoFamilia::all(); // todas porque pueden haber Tipos de Familias desactivadas con productos en stock;

        if ($request->all()) {

            $bodegaID = $request->bodegaID;
            $tipoID = $request->tipoID;
            $familiaID = $request->familiaID;
            $marcaID = $request->marcaID;

            $datos = [
                'bodegaID' => $bodegaID,
                'tipoID' => $tipoID,
                'familiaID' => $familiaID,
                'marcaID' => $marcaID,
                'formatoID' => $formatoID,
                'saborID' => $saborID
            ];

            $productos = Bodega::getStockFromBodegaOfPT($datos);
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
                'saborID' => $saborID,
                'formatoID' => $formatoID,
                'tipoID'      => $tipoID,
                'bodegaID'    => $bodegaID
            ]);
    }

    public function indexStockReport(Request $request) {

        $tipoFamilia = '';
        $familiaID = '';
        $tipoReporte = '';
        $productos = [];
        $tiposReporte = [
            ['id' => 0, 'descripcion' => 'total'],
            ['id' => 1, 'descripcion' => 'Ingreso'],
            ['id' => 2, 'descripcion' => 'Bodega'],
        ];

        $tiposProducto = TipoFamilia::getAllActive();
        $familias = Familia::getAllActive();

        if ($request->all()) {

            $familiaID = $request->familiaID;
            $tipoFamilia = $request->tipoFamilia;
            $tipoReporte = $request->tipoReporte;

            $productos = Bodega::getStockTotal($tipoReporte,$tipoFamilia,$familiaID);
        }

        return view('bodega.bodega.reportStock')
            ->with([
                'productos' => $productos,
                'tipoReporte' =>  $tipoReporte,
                'tipoFamilia' => $tipoFamilia,
                'familiaID' => $familiaID,
                'familias' => $familias,
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

        $datos = [
            'bodegaID' => $bodegaID,
            'tipoID' => $tipoID,
            'familiaID' => $familiaID,
            'marcaID' => $marcaID,
            'formatoID' => $formatoID,
            'saborID' => $saborID
        ];
        
        $productos = Bodega::getStockFromBodegaOfPT($datos);

        return Excel::create('Reporte Stock Bodega', function($excel) use ($productos) {
            $excel->sheet('New sheet', function($sheet) use ($productos) {
                $sheet->loadView('documents.excel.reportBodega')
                        ->with('productos', $productos);
                            })->download('xlsx');
                        });
    }

    /* DESCARGAR Reporte Stock Total */
    public function donwloadStockTotalReportExcel(Request $request) {


        $tipoFamilia = $request->tipoFamilia;
        $tipoReporte = $request->tipoReporte;
        $productos = Bodega::getStockTotal($tipoReporte,$tipoFamilia);

        return Excel::create('Reporte Stock Total', function($excel) use ($productos) {
            $excel->sheet('New sheet', function($sheet) use ($productos) {
                $sheet->loadView('documents.excel.reportStockTotal')
                        ->with('productos', $productos);
                            })->download('xlsx');
                        });
    }
}
