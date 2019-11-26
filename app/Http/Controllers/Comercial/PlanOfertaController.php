<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Producto;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\Canal;
use App\Models\Comercial\PlanOferta;
use App\Models\Comercial\PlanOfertaDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $planOfertas = PlanOferta::get();

      return view('comercial.planOfertas.index')->with(['planOfertas' => $planOfertas]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      /*
      |
      */
        $productos = Producto::getAllActive();
        $canales = Canal::getAllActive();
        $clientesNac = ClienteNacional::getAllActive();

        return view('comercial.planOfertas.create')->with(['productos' => $productos, 'clientesNac' => $clientesNac, 'canales' => $canales]);
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
          'fecha_inicio' => 'required',
          'fecha_termino' => 'required',
          'items' => 'required'
        ]);

        $planOferta = PlanOferta::register($request);

        return redirect()->route('planOfertas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\PlanOferta  $planOferta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planProduccion = PlanProduccion::with('detalles.producto')->find($id);

        return view('adquisicion.planProduccion.show')->with(['planProduccion' => $planProduccion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\PlanOferta  $planOferta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $planOfertas = PlanOferta::with('detalles')->find($id);
      $productos = Producto::getAllActive();
      $clientesNac = ClienteNacional::getAllActive();
      $canales = Canal::getAllActive();

      return view('comercial.planOfertas.edit')->with(['productos' => $productos, 'clientesNac' => $clientesNac, 'planOfertas' => $planOfertas, 'canales' => $canales]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\PlanOferta  $planOferta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
          'descripcion' => 'required',
          'fecha_inicio' => 'required',
          'fecha_termino' => 'required',
          'items' => 'required'
        ]);

        $planOferta = PlanOferta::registerEdit($request);

        return redirect()->route('planOfertas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\PlanProduccion  $planProduccion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $planOfertas = PlanOferta::destroy($id);

      $msg = "Plan de Ofertas N°". $id . " ha sido Eliminada.";

      return redirect()->route('planOfertas')->with(['status' => $msg]);
    }

}
