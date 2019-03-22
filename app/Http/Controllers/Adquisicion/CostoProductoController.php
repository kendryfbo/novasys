<?php

namespace App\Http\Controllers\Adquisicion;

use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adquisicion\CostoProducto;

class CostoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costosProducto = CostoProducto::totalCostoProducto();
        $dollar = CostoProducto::getDollarValue();

        return view('adquisicion.costosProducto.index')->with(['costosProducto' => $costosProducto,'dollar' => $dollar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function downloadExcel(Request $request) {


        $costosProducto = CostoProducto::totalCostoProducto();


        return Excel::create('Costos x Producto', function($excel) use ($costosProducto) {
            $excel->sheet('Costos x Producto', function($sheet) use ($costosProducto) {
                $sheet->loadView('documents.excel.reportCostoProducto')
                        ->with(['costosProducto' => $costosProducto]);
                    })->download('xlsx');
                })->download('xlsx');

    }
}
