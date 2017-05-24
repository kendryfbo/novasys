<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Familia;
use App\Models\Unidad;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insumos = Insumo::all();

        return view('desarrollo.insumos.index')->with(['insumos' => $insumos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familias = Familia::getAllactive()->where('tipo_id',1);
        $unidades = Unidad::getAllActive();

        return view('desarrollo.insumos.create')->with(['familias' => $familias, 'unidades' => $unidades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required|unique:insumos',
            'descripcion' => 'required',
            'familia' => 'required',
            'unidad' => 'required'
        ]);
        $activo = !empty($request->activo);

        Insumo::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'familia_id' => $request->familia,
            'unidad_med' => $request->unidad,
            'stock_min' => $request->stock_min,
            'stock_max' => $request->stock_max,
            'activo' => $activo
        ]);

        $msg = "Insumo: " . $request->descripcion . " ha sido Creado.";

        return redirect(route('insumos'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function show(Insumo $insumo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function edit(Insumo $insumo)
    {
        $familias = Familia::getAllactive()->where('tipo_id',1);
        $unidades = Unidad::getAllActive();

        return view('desarrollo.insumos.edit')
                ->with(['insumo' => $insumo,
                        'familias' => $familias,
                        'unidades' => $unidades]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insumo $insumo)
    {
        $this->validate($request,[
            'descripcion' => 'required',
            'familia' => 'required',
            'unidad' => 'required'
        ]);
        $activo = !empty($request->activo);

        $insumo->descripcion = $request->descripcion;
        $insumo->familia_id = $request->familia;
        $insumo->unidad_med = $request->unidad;
        $insumo->stock_min = $request->stock_min;
        $insumo->stock_max = $request->stock_max;
        $insumo->activo = $activo;

        $insumo->save();

        $msg = "Insumo: " . $insumo->descripcion . " ha sido Modificado.";

        return redirect(route('insumos'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insumo $insumo)
    {
        Insumo::destroy($insumo->id);

        $msg = "Insumo: " . $insumo->descripcion . " ha sido Eliminado.";

        return redirect(route('insumos'))->with(['status' => $msg]);
    }

    public function getInsumos(Request $request) {

        if ($request->familia) {
            return Insumo::getAllActive()->where('familia_id', $request->familia);
        }

        return Insumo::getAllActive()->get();
    }
}
