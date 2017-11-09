<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Producto;
use App\Models\Produccion\TerminoProceso;

class TerminoProcesoController extends Controller
{

    /* Constantes Temporales hasta implementar tablas */
    const MAQUINAS = ['A','B','C','D','E','F','G','H','I','J','K','L','M','R'];
    const OPERADORES = [0,1,2,3,4,5,6,7,8,9];
    const CODIGOS = ['Z'];
    const BATCHS = [1,2,3,4,5,6,7,8,9];
    const TURNOS = ['Dia', 'Tarde', 'Noche'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producciones = TerminoProceso::with('producto')->where('procesado',0)->get();

        return view('produccion.terminoProceso.index')->with(['producciones' => $producciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maquinas = self::MAQUINAS;
        $operadores = self::OPERADORES;
        $codigos = self::CODIGOS;
        $batchs = self::BATCHS;
        $turnos = self::TURNOS;
        $productos = Producto::getAllActive();


        return view('produccion.terminoProceso.create')->with(
            ['maquinas' => $maquinas,'operadores' => $operadores, 'codigos' => $codigos,
             'batchs' => $batchs, 'turnos' => $turnos, 'productos' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $this->validate($request,[
            'prod_id' => 'required',
            'fecha_prod' => 'required|date',
            'fecha_venc' => 'required|date',
            'turno' => 'required',
            'producidas' => 'required',
            'rechazadas' => 'required',
            'maquina' => 'required',
            'operador' => 'required',
            'batch' => 'required',
            'lote' => 'required'
        ]);


        $datos['total'] = $datos['producidas'] + $datos['rechazadas'];
        $datos['por_procesar'] = $datos['total'];

        $produccion = TerminoProceso::create($datos);

        $status = 'Termino de Proceso creado, Lote Nº '. $produccion->lote;

        return redirect()->route('terminoProceso')->with(['status' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TerminoProceso $terminoProceso)
    {
        $maquinas = self::MAQUINAS;
        $operadores = self::OPERADORES;
        $codigos = self::CODIGOS;
        $batchs = self::BATCHS;
        $turnos = self::TURNOS;
        $productos = Producto::getAllActive();

        return view('produccion.terminoProceso.edit')->with(
            ['terminoProceso' => $terminoProceso, 'maquinas' => $maquinas,'operadores' => $operadores,
             'codigos' => $codigos, 'batchs' => $batchs, 'turnos' => $turnos, 'productos' => $productos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $produccion = TerminoProceso::destroy($id);

        $status = 'Termino de Proceso Eliminado';

        return redirect()->route('terminoProceso')->with(['status' => $status]);
    }
}
