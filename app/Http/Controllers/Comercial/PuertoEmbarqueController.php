<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\PuertoEmbarque;
use App\Models\Comercial\MedioTransporte;


class PuertoEmbarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puertosEmbarque = PuertoEmbarque::all();

        return view('comercial.puertoEmbarque.index')->with(['puertosEmbarque' => $puertosEmbarque]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mediosTransporte = MedioTransporte::getAllActive();

        return view('comercial.puertoEmbarque.create')->with(['mediosTransporte' => $mediosTransporte]);
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
            'nombre' => 'required',
            'direccion' => 'required',
            'tipo' => 'required',
            'comuna' => 'required',
            'ciudad' => 'required',
            'fono' => 'required'
        ]);

        $activo = !empty($request->activo);

        PuertoEmbarque::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'tipo' => $request->tipo,
            'comuna' => $request->comuna,
            'ciudad' => $request->ciudad,
            'fono' => $request->fono,
            'activo' => $activo
        ]);

        $msg = 'Puerto Embarque ' . $request->nombre . ' Ha sido creado.';

        return redirect(route('puertoEmbarque'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\PuertoEmbarque  $puertoEmbarque
     * @return \Illuminate\Http\Response
     */
    public function show(PuertoEmbarque $puertoEmbarque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\PuertoEmbarque  $puertoEmbarque
     * @return \Illuminate\Http\Response
     */
    public function edit(PuertoEmbarque $puertoEmbarque)
    {
        $mediosTransporte = MedioTransporte::getAllActive();

        return view('comercial.puertoEmbarque.edit')->with([
            'puerto' => $puertoEmbarque,
            'mediosTransporte' => $mediosTransporte
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\PuertoEmbarque  $puertoEmbarque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PuertoEmbarque $puertoEmbarque)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'direccion' => 'required',
            'tipo' => 'required',
            'comuna' => 'required',
            'ciudad' => 'required',
            'fono' => 'required'
        ]);

        $activo = !empty($request->activo);

        $puertoEmbarque->nombre = $request->nombre;
        $puertoEmbarque->direccion = $request->direccion;
        $puertoEmbarque->tipo = $request->tipo;
        $puertoEmbarque->comuna = $request->comuna;
        $puertoEmbarque->ciudad = $request->ciudad;
        $puertoEmbarque->fono = $request->fono;
        $puertoEmbarque->activo = $activo;

        $puertoEmbarque->save();

        $msg = 'Puerto Embarque ' . $request->nombre . ' Ha sido Modificado.';

        return redirect(route('puertoEmbarque'))->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\PuertoEmbarque  $puertoEmbarque
     * @return \Illuminate\Http\Response
     */
    public function destroy(PuertoEmbarque $puertoEmbarque)
    {
        $puertoEmbarque->delete();

        $msg = 'Puerto Embarque ' . $puertoEmbarque->nombre . ' Ha sido Eliminado.';

        return redirect(route('puertoEmbarque'))->with(['status' => $msg]);
    }
}
