<?php

namespace App\Http\Controllers;

use App\Models\Sabor;
use Illuminate\Http\Request;

class SaborController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sabores = Sabor::all();
        return view('desarrollo.sabores.index')->with(['sabores' => $sabores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('desarrollo.sabores.create');
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
            'descrip_ing' => 'required'
        ]);

        $activo = !empty($request->activo);

        Sabor::create([
            'descripcion' => $request->descripcion,
            'descrip_ing' => $request->descrip_ing,
            'activo' => $activo,
        ]);

        $msg = "Sabor: " . $request->descripcion . " ha sido Creado";

        return redirect(route('sabores'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function show(Sabor $sabor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sabor $sabor)
    {
        return view('desarrollo.sabores.edit')->with(['sabor' => $sabor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sabor $sabor)
    {
        $this->validate($request,[
            'descripcion' => 'required',
            'descrip_ing' => 'required',
        ]);

        $activo = !empty($request->activo);

        $sabor->descripcion = $request->descripcion;
        $sabor->descrip_ing = $request->descrip_ing;
        $sabor->activo = $activo;
        $sabor->save();

        $msg = "Sabor: " . $sabor->descripcion . " ha sido Actualizada";

        return redirect(route('sabores'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sabor $sabor)
    {
        Sabor::destroy($sabor->id);

        $msg = "Sabor: " . $sabor->descripcion . " ha sido Eliminado";

        return redirect(route('sabores'))->with(['status' => $msg]);
    }
}
