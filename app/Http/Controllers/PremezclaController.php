<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Sabor;
use App\Models\Familia;
use App\Models\Formato;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Premezcla;

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
        $premezclas = Premezcla::with('familia','marca','sabor','formato')->get();

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
        $formatos = Formato::getAllActive();

        return view('desarrollo.premezclas.create')
                ->with(['familia' => $familia,
                        'marcas' => $marcas,
                        'sabores' => $sabores,
                        'formatos' => $formatos
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
            'formato' => 'required'
        ]);
        $activo = !empty($request->activo);

        Premezcla::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'familia_id' => $request->familia,
            'marca_id' => $request->marca,
            'sabor_id' => $request->sabor,
            'formato_id' => $request->formato,
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
        $formatos = Formato::getAllActive();

        return view('desarrollo.premezclas.edit')
                ->with(['premezcla' => $premezcla,
                        'familia' => $familia,
                        'marcas' => $marcas,
                        'sabores' => $sabores,
                        'formatos' => $formatos,
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
        $this->validate($request, [
            'codigo' => 'required',
            'descripcion' => 'required',
            'familia' => 'required',
            'marca' => 'required',
            'sabor' => 'required',
            'formato' => 'required'
        ]);
        $activo = !empty($request->activo);
        $premezcla->codigo = $request->codigo;
        $premezcla->descripcion = $request->descripcion;
        $premezcla->familia_id = $request->familia;
        $premezcla->marca_id = $request->marca;
        $premezcla->sabor_id = $request->sabor;
        $premezcla->formato_id = $request->formato;
        $premezcla->activo = $activo;
        $premezcla->save();

        $msg = "Premezcla: " . $premezcla->descripcion . " ha sido Actualizada.";

        return redirect(route('premezclas'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Premezcla  $premezcla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Premezcla $premezcla)
    {
        dd('Por implementar');

        // comentado hasta asegurar integridad - relacion formula Premezcla
        /*
        Premezcla::destroy($premezcla->id);

        $msg = "Premezcla: " . $premezcla->descripcion . " ha sido Eliminada.";

        return redirect(route('premezclas'))->with(['status' => $msg]);
        */
    }

}
