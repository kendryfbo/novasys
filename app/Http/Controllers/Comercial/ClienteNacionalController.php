<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteNacionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = ClienteNacional::with(['region:id,descripcion', 'vendedor:id,nombre'])->get();

        return view('comercial.clientesNacionales.index')->with(['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendedores = Vendedor::getAllActive();
        $regiones = Region::all();

        return view('comercial.clientesNacionales.create')->with([
            'vendedores' => $vendedores,
            'regiones' => $regiones
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
        $this->validate($request, [
            'rut' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        //    'fono' => 'required',
            'giro' => 'required',
        //    'fax' => 'required',
            'rut_num' => 'required',
        //    'contacto' => 'required',
        //    'cargo' => 'required',
        //    'email' => 'required',
            'region_id' => 'required',
            'provincia_id' => 'required',
            'comuna_id' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClienteNacional  $clienteNacional
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteNacional $clienteNacional)
    {
        return "SHOW";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClienteNacional  $clienteNacional
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteNacional $clienteNacional)
    {
        return "EDIT";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClienteNacional  $clienteNacional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClienteNacional $clienteNacional)
    {
        $this->validate($request, [
            'rut' => 'required',
            'descripcion' => 'required',
            'direccion' => 'required',
        //    'fono' => 'required',
            'giro' => 'required',
        //    'fax' => 'required',
            'rut_num' => 'required',
        //    'contacto' => 'required',
        //    'cargo' => 'required',
        //    'email' => 'required',
            'region_id' => 'required',
            'provincia_id' => 'required',
            'comuna_id' => 'required'
        ]);

        return "UPDATE";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClienteNacional  $clienteNacional
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteNacional $clienteNacional)
    {
        return "DELETE";
    }
}
