<?php

namespace App\Http\Controllers\Produccion;

use App\Models\Nivel;
use App\Models\Formula;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produccion\ProduccionMezclado;

class ProduccionMezcladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodMezclado = ProduccionMezclado::with('premezcla')->get();

        return view('produccion.mezclado.index')->with(['prodMezclado' => $prodMezclado]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nivelPremix = Nivel::produccionID();
        $formulas = Formula::with('producto','premezcla')->where('autorizado',1)->get();
        $formulas->load(['detalle' => function ($query) use ($nivelPremix){
            $query->where('nivel_id',$nivelPremix);
        },'detalle.insumo','detalle.nivel']);

        return view('produccion.mezclado.create')->with([
            'formulas' => $formulas,
        ]);
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
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function show(ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduccionMezclado $produccionMezclado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Produccion\ProduccionMezclado  $produccionMezclado
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduccionMezclado $produccionMezclado)
    {
        //
    }
}
