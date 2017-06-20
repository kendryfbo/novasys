<?php

namespace App\Http\Controllers\Api;

use App\Models\Comercial\ListaPrecio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListaPrecioController extends Controller
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
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPrecio $lista)
    {
        try {

            $lista->load('detalle.producto.marca');

            return response($lista,200);

        } catch (Exception $e) {

            return response('error',400);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaPrecio $listaPrecio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPrecio $listaPrecio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\ListaPrecio  $listaPrecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaPrecio $listaPrecio)
    {
        //
    }
}
