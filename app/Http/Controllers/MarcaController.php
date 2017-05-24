<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Familia;

use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Marca::all();

        return view('desarrollo.marcas.index')->with(['marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familias = Familia::getAllActive();

        return view('desarrollo/marcas/create')->with(['familias' => $familias]);
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
            'codigo' => 'required|min:3|max:10',
            'descripcion' => 'required',
            'familia' => 'required'
        ]);

        $activo = !empty($request->activo);
        $iaba = !empty($request->iaba);
        $nacional = !empty($request->nacional);

        Marca::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'familia_id' => $request->familia,
            'activo' => $activo,
            'iaba' => $iaba,
            'nacional' => $nacional
        ]);

        $msg = "Marca: " . $request->descripcion . " ha sido Creada.";

        return redirect(route('marcas'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marcas  $marcas
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marcas  $marcas
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        $familias = Familia::getAllActive();

        return view('desarrollo.marcas.edit')
        ->with([
            'marca' => $marca,
            'familias' => $familias
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marcas  $marcas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        $this->validate($request,[
            'descripcion' => 'required',
            'familia' => 'required'
        ]);

        $marca->descripcion = $request->descripcion;
        $marca->familia_id = $request->familia;
        $marca->activo = !empty($request->activo);
        $marca->iaba = !empty($request->iaba);
        $marca->nacional = !empty($request->nacional);
        $marca->save();

        return redirect(route('marcas'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marcas  $marcas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        Marca::destroy($marca->id);

        $msg = "Marca: " . $marca->descripcion . " ha sido Eliminada.";

        return redirect(route('marcas'))->with(['status' => $msg]);
    }

    public function getMarcas() {

        return Marca::getAllActive();
    }
}
