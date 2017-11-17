<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Insumo;
use App\Models\Producto;
use App\Models\Bodega\Ingreso;
use App\Models\Bodega\IngresoTipo;
use App\Models\Produccion\TerminoProceso;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingresos = Ingreso::with('usuario','tipo')->where('procesado',0)->get();

        return view('bodega.ingreso.index')->with([
            'ingresos' => $ingresos
        ]);
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

    public function createIngManualMP()
    {
        $tipoIngreso = config('globalVars.ingresoManual');
        $tipoProd = config('globalVars.MP');
        $insumos = Insumo::getAllActive();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.ingreso.createIngManualMP')->with([
            'insumos' => $insumos,
            'tipoIngreso' => $tipoIngreso,
            'tipoProd' => $tipoProd,
            'fecha' => $fecha,
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
        //
    }

    public function storeIngManualMP(Request $request)
    {

        $this->validate($request,[
            'descripcion' =>'required',
            'tipo_ingreso' => 'required',
            'tipo_prod' => 'required',
            'fecha' => 'required|date',
            'items' => 'required',
        ]);

        $ingreso = Ingreso::register($request);
        $msg = "Ingreso N°". $ingreso->numero . " ha sido Creada.";

        return redirect()->route('ingreso')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function show(Ingreso $ingreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingreso $ingreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingreso $ingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingreso $ingreso)
    {
        $ingreso->delete();

        $msg = 'Ingreso Nº' . $ingreso->numero . ' ha sido Eliminado.';

        return redirect()->route('ingreso')->with([
            'status' => $msg
        ]);
    }
}
