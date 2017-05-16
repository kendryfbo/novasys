<?php

namespace App\Http\Controllers;

use App\Models\Premezcla;
use App\Models\Familia;
use App\Models\Marca;
use App\Models\Sabor;
use App\Models\Unidad;

use Illuminate\Http\Request;

class PremezclaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premezclas = Premezcla::all();

        return view('desarrollo.premezclas.index')->with(['premezclas' => $premezclas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familia = Familia::where('id',1)->first();
        $marcas = Marca::getAllActive();
        $sabores = Sabor::getAllActive();
        $unidades = Unidad::getAllActive();

        return view('desarrollo.premezclas.create')
                ->with(['familia' => $familia,
                        'marcas' => $marcas,
                        'sabores' => $sabores,
                        'unidades' => $unidades
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
        $this->validate($request,[
            'codigo' => 'required|unique:premezclas',
            'descripcion' => 'required',
            'familia' => 'required',
            'marca' => 'required',
            'sabor' => 'required',
            'unidad' => 'required'
        ]);
        $activo = !empty($request->activo);

        Premezcla::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'familia_id' => $request->familia,
            'marca_id' => $request->marca,
            'sabor_id' => $request->sabor,
            'unidad_med' => $request->unidad,
            'activo' => $activo
        ]);

        $msg = "Premezcla: " . $request->descripcion . " ha sido Creado.";

        return redirect(route('premezclas'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Premezcla  $premezcla
     * @return \Illuminate\Http\Response
     */
    public function show(Premezcla $premezcla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Premezcla  $premezcla
     * @return \Illuminate\Http\Response
     */
    public function edit(Premezcla $premezcla)
    {
        $familia = Familia::where('id',1)->first();
        $marcas = Marca::getAllActive();
        $sabores = Sabor::getAllActive();
        $unidades = Unidad::getAllActive();

        return view('desarrollo.premezclas.edit')
                ->with(['premezcla' => $premezcla,
                        'familia' => $familia,
                        'marcas' => $marcas,
                        'sabores' => $sabores,
                        'unidades' => $unidades
                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Premezcla  $premezcla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Premezcla $premezcla)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Premezcla  $premezcla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Premezcla $premezcla)
    {
        Premezcla::destroy($premezcla->id);

        $msg = "Premezcla: " . $premezcla->descripcion . " ha sido Eliminada.";

        return redirect(route('premezclas'))->with(['status' => $msg]);

    }
    
}
