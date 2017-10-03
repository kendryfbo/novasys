<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\FormaPagoIntl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormaPagoIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $formasPagos = FormaPagoIntl::all();

      return view('comercial.FormaPagoIntl.index')->with(['formasPagos' => $formasPagos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('comercial.formaPagoIntl.create');
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

      FormaPagoIntl::create([
        'descripcion' => $request->descripcion,
        'dias' => $request->dias,
        'activo' => $activo,
      ]);

      $msg = 'Condicion de Pago: ' . $request->descripcion . ' Ha sido Creado.';

      return redirect(route('formaPagoIntl'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\FormaPagoIntl  $formaPagoIntl
     * @return \Illuminate\Http\Response
     */
    public function show(FormaPagoIntl $formaPagoIntl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\FormaPagoIntl  $formaPagoIntl
     * @return \Illuminate\Http\Response
     */
    public function edit(FormaPagoIntl $formaPagoIntl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FormaPagoIntl  $formaPagoIntl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormaPagoIntl $formaPagoIntl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\FormaPagoIntl  $formaPagoIntl
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormaPagoIntl $formaPagoIntl)
    {
        //
    }
}
