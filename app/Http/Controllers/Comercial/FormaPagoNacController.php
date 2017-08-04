<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\FormaPagoNac;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormaPagoNacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $formasPagos = FormaPagoNac::all();

      return view('comercial.formaPagoNac.index')->with(['formasPagos' => $formasPagos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      return view('comercial.formaPagoNac.create');
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
      ]);

      $activo = !empty($request->activo);

      FormaPagoNac::create([
        'descripcion' => $request->descripcion,
        'activo' => $activo,
      ]);

      $msg = 'Condicion de Pago: ' . $request->descripcion . ' Ha sido Creado.';

      return redirect(route('formasPagos.index'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\FormaPagoNac  $formaPagoNac
     * @return \Illuminate\Http\Response
     */
    public function show(FormaPagoNac $formaPagoNac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\FormaPagoNac  $formaPagoNac
     * @return \Illuminate\Http\Response
     */
    public function edit(FormaPagoNac $formaPagoNac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FormaPagoNac  $formaPagoNac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormaPagoNac $formaPagoNac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\FormaPagoNac  $formaPagoNac
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormaPagoNac $formaPagoNac)
    {
        //
    }
}
