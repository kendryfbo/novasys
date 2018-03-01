<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TipoFamilia;
use App\Models\Bodega\Bodega;

class BodegaReportController extends Controller
{
    public function indexBodegaReport(Request $request) {

        $busqueda = [];
        $productos = [];
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
                'tiposProducto' => $tiposProducto
            ]);
    }
}
