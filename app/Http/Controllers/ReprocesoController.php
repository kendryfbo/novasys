<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Sabor;
use App\Models\Familia;
use App\Models\Formato;
use App\Models\Formula;
use App\Models\Producto;
use App\Models\Reproceso;

use Illuminate\Http\Request;

class ReprocesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reprocesos = Reproceso::with('familia','marca','sabor','formato')->get();

        return view('desarrollo.reproceso.index')->with(['reprocesos' => $reprocesos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $famReproceso = 23; // ID familia reproceso.
        $familia = Familia::where('id',$famReproceso)->first();
        $marcas = Marca::getAllActive();
        $sabores = Sabor::getAllActive();
        $formatos = Formato::getAllActive();

        return view('desarrollo.reproceso.create')
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
            'codigo' => 'required|unique:reprocesos',
            'descripcion' => 'required',
            'familia' => 'required',
            'marca' => 'required',
            'sabor' => 'required',
            'formato' => 'required'
        ]);
        $activo = !empty($request->activo);

        Reproceso::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'familia_id' => $request->familia,
            'marca_id' => $request->marca,
            'sabor_id' => $request->sabor,
            'formato_id' => $request->formato,
            'activo' => $activo
        ]);

        $msg = "Reproceso: " . $request->descripcion . " ha sido Creado.";

        return redirect(route('reprocesos'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reproceso $reproceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reproceso $reproceso)
    {
        $famReproceso = 23; // ID familia reproceso.
        $familia = Familia::where('id',$famReproceso)->first();
        $marcas = Marca::getAllActive();
        $sabores = Sabor::getAllActive();
        $formatos = Formato::getAllActive();

        return view('desarrollo.reproceso.edit')
                ->with(['reproceso' => $reproceso,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reproceso $reproceso)
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
        $reproceso->codigo = $request->codigo;
        $reproceso->descripcion = $request->descripcion;
        $reproceso->familia_id = $request->familia;
        $reproceso->marca_id = $request->marca;
        $reproceso->sabor_id = $request->sabor;
        $reproceso->formato_id = $request->formato;
        $reproceso->activo = $activo;
        $reproceso->save();

        $msg = "Reproceso: " . $reproceso->descripcion . " ha sido Actualizada.";

        return redirect(route('reprocesos'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reproceso $reproceso)
    {
        dd('Por implementar');

        // comentado hasta asegurar integridad - relacion formula Reproceso
        /*
        Reproceso::destroy($reproceso->id);

        $msg = "Premezcla: " . $reproceso->descripcion . " ha sido Eliminada.";

        return redirect(route('premezclas'))->with(['status' => $msg]);
        */
    }
}
