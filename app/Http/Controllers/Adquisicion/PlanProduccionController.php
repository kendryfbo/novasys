<?php

namespace App\Http\Controllers\Adquisicion;

use Excel;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adquisicion\PlanProduccion;

class PlanProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('crearPlanProduccion');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::has('formula')->where('activo',1)->get();

        return view('adquisicion.planProduccion.create')->with(['productos' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function showAnalReqWithStock(Request $request) // Toma en cuenta producto terminado existente
    {
        if (!$request->items) {
            return redirect()->back();
        }

        $items = $request->items;
        $plan = PlanProduccion::analisisRequerimientosConStock($items);
        $productos = $plan[0];
        $insumos = $plan[1];
        return view('adquisicion.planProduccion.showWithStock')
                ->with(['productos' => $productos,
                        'insumos' => $insumos,
                        'items' => $items]);
    }

    public function showAnalReq(Request $request) // NO Toma en cuenta producto terminado existente
    {
        if ($request->button == 2) {

            return $this->showAnalReqWithStock($request);
        }
        if (!$request->items) {
            return redirect()->back();
        }
        $items = $request->items;
        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];

        return view('adquisicion.planProduccion.show')
                ->with(['productos' => $productos,
                        'insumos' => $insumos,
                        'items' => $items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanProduccion $planProduccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanProduccion $planProduccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanProduccion $planProduccion)
    {
        //
    }

    public function downloadExcelAnalReq(Request $request) {

        $items = $request->items;

        if (!$items) {
            dd('no items');
        }

        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];
        /*
        $excel = Excel::create('Analisis de Produccion', function($excel) use ($insumos) {
            $excel->sheet('New sheet', function($sheet) use ($insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetInsumos')
                        ->with('insumos', $insumos);
                            });
                        });

        return $excel->download('xlsx');
        */

        return Excel::create('Analisis de Produccion', function($excel) use ($productos,$insumos) {
            $excel->sheet('Resumen', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetResum')
                        ->with(['productos' => $productos,'insumos' => $insumos]);
                    });
            $excel->sheet('Insumos', function($sheet) use ($insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetInsumos')
                        ->with(['insumos' => $insumos]);
                    })->download('xlsx');
                })->download('xlsx');

    }
    public function downloadExcelAnalReqConStock(Request $request) {

        $items = $request->items;

        if (!$items) {
            dd('no items');
        }

        $plan = PlanProduccion::analisisRequerimientosConStock($items);
        $productos = $plan[0];
        $insumos = $plan[1];

        return Excel::create('Analisis de Produccion', function($excel) use ($productos,$insumos) {
            $excel->sheet('Resumen', function($sheet) use ($productos,$insumos) {
                $sheet->loadView('documents.excel.reportAnalReqConStockSheetResum')
                        ->with(['productos' => $productos,'insumos' => $insumos]);
                    });
            $excel->sheet('Insumos', function($sheet) use ($insumos) {
                $sheet->loadView('documents.excel.reportAnalReqSheetInsumos')
                        ->with(['insumos' => $insumos]);
                    })->download('xlsx');
                })->download('xlsx');
    }
}
