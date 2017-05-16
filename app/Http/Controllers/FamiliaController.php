<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use App\Models\TipoFamilia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familias = Familia::all();
        return view('desarrollo.familias.index')->with(['familias' => $familias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoFamilias = TipoFamilia::getAllActive();

        return view('desarrollo.familias.create')->with(['tiposFamilia' => $tipoFamilias]);
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
            'codigo' => 'required|unique:familias,codigo|max:10',
            'descripcion' => 'required',
            'tipo' => 'required'
        ]);

        $activo = !empty($request->activo);

        Familia::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'tipo_id' => $request->tipo,
            'activo' => $activo,
        ]);

        return redirect(route('familias'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function show(Familia $familia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function edit(Familia $familia)
    {
        $tipoFamilias = TipoFamilia::getAllactive();
        return view('desarrollo.familias.edit')
                ->with(['familia' => $familia,
                        'tiposFamilia' => $tipoFamilias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Familia $familia)
    {
        $this->validate($request, [
            'codigo' => 'required',
            'descripcion' => 'required',
            'tipo' => 'required'
        ]);
        $activo = !empty($request->activo);
        $familia->descripcion = $request->descripcion;
        $familia->tipo_id = $request->tipo;
        $familia->activo = $activo;
        $familia->save();
        $msg = "Familia codigo: " . $familia->codigo . " ha sido Actualizada";
        return redirect('desarrollo/familias')->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Familia  $familia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Familia $familia)
    {
        Familia::destroy($familia->id);

        $msg = "Familia codigo: " . $familia->codigo . " Ha sido eliminada";

        return redirect('desarrollo/familias')->with(['status' => $msg]);
    }
}
