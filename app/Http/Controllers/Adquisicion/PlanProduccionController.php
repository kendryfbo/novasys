<?php

namespace App\Http\Controllers\Adquisicion;

use App\Models\Adquisicion\PlanProduccion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planes = [];//PlanProduccion::all();
        return view('adquisicion.planProduccion.index')->with(['planes' => $planes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function show(PlanProduccion $planProduccion)
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
}
