<?php

namespace App\Http\Controllers\Adquisicion;

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
        $productos = Producto::getAllActive();

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
    public function show(Request $request) // Toma en cuenta producto terminado existente
    {
        if (!$request->items) {
            return redirect()->back();
        }

        $items = $request->items;
        $plan = PlanProduccion::analisisRequerimientos($items);
        $productos = $plan[0];
        $insumos = $plan[1];
        return view('adquisicion.planProduccion.show')->with(['productos' => $productos, 'insumos' => $insumos]);
    }
    public function showTwo(Request $request) // NO Toma en cuenta producto terminado existente
    {
        if ($request->button == 2) {

            return $this->show($request);
        }
        if (!$request->items) {
            return redirect()->back();
        }
        $items = $request->items;
        $plan = PlanProduccion::requerimientoDeCompra($items);
        $productos = $plan[0];
        $insumos = $plan[1];

        return view('adquisicion.planProduccion.showTwo')->with(['productos' => $productos, 'insumos' => $insumos]);
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
}
