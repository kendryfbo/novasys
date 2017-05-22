<?php

namespace App\Http\Controllers;

use App\Models\FormulaDetalle;
use Illuminate\Http\Request;

class FormulaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('INDEX');
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
        $this->validate($request,[
            'formula' => 'required',
            'codigo' => 'required',
            'descripcion' => 'required',
            'nivel' => 'required',
            'cantxuni' => 'required',
            'cantxcaja' => 'required',
            'cantxbatch' => 'required',
            'batch' => 'required'
        ]);

        FormulaDetalle::Create([
            'formula_id' => $request->formula ,
            'insumo_cod' => $request->codigo ,
            'insumo_descrip' => $request->descripcion ,
            'nivel_id' => $request->nivel ,
            'cantxuni' => $request->cantxuni ,
            'cantxcaja' => $request->cantxcaja ,
            'cantxbatch' => $request->cantxbatch ,
            'batch' => $request->batch
        ]);

        return ('Insumo agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(FormulaDetalle $formulaDetalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(FormulaDetalle $formulaDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormulaDetalle $formulaDetalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormulaDetalle  $formulaDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormulaDetalle $formulaDetalle)
    {
        //
    }

    public function getFormulaDetalle(Request $request) {

        if($request->formula){
            return FormulaDetalle::all()->where('formula_id',$request->formula);
        }
    }
}
