<?php

namespace App\Http\Controllers\Adquisicion;

use App\Models\Adquisicion\FormaPagoProveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormaPagoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formasPagos = FormaPagoProveedor::all();

        return view('adquisicion.formaPago.index')->with(['formasPagos' =>$formasPagos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adquisicion.formaPago.create');
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
            'dias' => 'required'
        ]);

        $activo = !empty($request->activo);

        FormaPagoProveedor::create([
            'descripcion' => $request->descripcion,
            'dias' => $request->dias,
            'activo' => $activo
        ]);

        $msg = 'Forma Pago ' . $request->descripcion . ' ha sido creado.';

        return redirect()->route('formaPagoProveedor')->with('status', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adquisicion\FormaPagoProveedor  $formaPagoProveedor
     * @return \Illuminate\Http\Response
     */
    public function show(FormaPagoProveedor $formaPagoProveedor)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adquisicion\FormaPagoProveedor  $formaPagoProveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(FormaPagoProveedor $formaPagoProveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adquisicion\FormaPagoProveedor  $formaPagoProveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormaPagoProveedor $formaPagoProveedor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\FormaPagoProveedor  $formaPagoProveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormaPagoProveedor $formaPagoProveedor)
    {
        //
    }
}
