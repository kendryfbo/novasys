<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Models\Familia;
use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;

class BodegaReportController extends Controller
{
    public function indexBodegaReport(Request $request) {

        $busqueda = [];
        $productos = [];
        $tipo = '';
        $bodegaID= '';
        $bodegas = Bodega::getAllActive();
        $tiposProducto = TipoFamilia::getAllActive();

        if ($request->all()) {

            $bodegaID = $request->bodega;
            $tipo = $request->tipo;
            $productos = Bodega::getStockFromBodega($bodegaID,$tipo);
        }

        return view('bodega.bodega.reportBodega')
            ->with([
                'busqueda' =>  $busqueda,
                'productos' => $productos,
                'bodegas' => $bodegas,
                'tiposProducto' => $tiposProducto,
                'tipo' => $tipo,
                'bodega' => $bodegaID
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


        $bodegaID = $request->bodega ? $request->bodega : '';
        $tipo = $request->tipo ? $request->tipo : '';
        $productos = Bodega::getStockFromBodega($bodegaID,$tipo);

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
