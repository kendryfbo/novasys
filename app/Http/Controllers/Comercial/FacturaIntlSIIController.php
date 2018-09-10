<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\FacturaIntl; // Temporalmente
use App\Models\Comercial\FacturaIntlSII;

class FacturaIntlSIIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = FacturaIntl::orderBy('numero')->take(20)->get();

        return view('comercial.facturaIntlSII.index')->with(['facturas' => $facturas]);
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
     * @param  \App\Models\Comercial\FacturaIntlSII  $facturaIntlSII
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $factura = FacturanIntl::where('numero',$numero)->first();

        return view('comercial.facturaIntlSII.show')->with(['factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaIntlSII  $facturaIntlSII
     * @return \Illuminate\Http\Response
     */
    public function edit(FacturaIntlSII $facturaIntlSII)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FacturaIntlSII  $facturaIntlSII
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacturaIntlSII $facturaIntlSII)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\FacturaIntlSII  $facturaIntlSII
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacturaIntlSII $facturaIntlSII)
    {
        //
    }
}
