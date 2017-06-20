<?php

namespace App\Http\Controllers\Api;

use App\Models\Comercial\ClienteNacional;
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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\ClienteNacional  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteNacional $cliente)
    {
        try {

            $cliente->load('sucursal', 'listaPrecio.detalle.producto.marca','listaPrecio.detalle.producto.formato', 'canal');

            return response()->json($cliente);

        } catch (Exception $e) {


            return response('No encontrado',404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\ClienteNacional  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteNacional $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\ClienteNacional  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClienteNacional $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\ClienteNacional  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteNacional $cliente)
    {
        //
    }
}
