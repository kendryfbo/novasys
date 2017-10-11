<?php

namespace App\Http\Controllers;

use App\Models\Formato;
use App\Models\Unidad;
use Illuminate\Http\Request;

class FormatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formatos = Formato::all();
        return view('desarrollo.formatos.index')->with(['formatos' => $formatos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('desarrollo.formatos.create');
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
            'descripcion' => 'required',
            'peso_uni'    => 'required',
            'peso_neto'   => 'required'
        ]);

        $activo = !empty($request->activo);

        Formato::create([
            'descripcion' => $request->descripcion,
            'peso_uni' => $request->peso_uni,
            'peso_neto' => $request->peso_neto,
            'activo' => $activo,
        ]);

        $msg = "Formato: " . $request->descripcion . " ha sido Creado.";

        return redirect(route('formatos'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formato  $formato
     * @return \Illuminate\Http\Response
     */
    public function show(Formato $formato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formato  $formato
     * @return \Illuminate\Http\Response
     */
    public function edit(Formato $formato)
    {
        return view('desarrollo.formatos.edit')->with(['formato' => $formato]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formato  $formato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formato $formato)
    {
        $this->validate($request,[
            'descripcion' => 'required',
            'peso_uni' => 'required',
            'peso_neto' => 'required'
        ]);

        $activo = !empty($request->activo);

        $formato->descripcion = $request->descripcion;
        $formato->peso_uni = $request->peso_uni;
        $formato->peso_neto = $request->peso_neto;
        $formato->activo = $activo;

        $formato->save();

        $msg = "Formato: " . $request->descripcion . " ha sido Actualizado.";
        return redirect(route('formatos'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formato  $formato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formato $formato)
    {
        Formato::destroy($formato->id);
        $msg = "Formato: " . $formato->descripcion . " ha sido Eliminado.";
        return redirect(route('formatos'))->with(['status' => $msg]);
    }

    public function getFormatos() {

        return Formato::all();
    }
}
