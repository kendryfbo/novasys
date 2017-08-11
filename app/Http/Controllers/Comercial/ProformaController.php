<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\Proforma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\ClausulaVenta;
use App\Models\Comercial\MedioTransporte;
use App\Models\Comercial\Aduana;
use App\Models\Producto;

class ProformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $proformas = Proforma::orderBy('numero')->take(20);

      return view('comercial.proforma.index')->with(['proformas' => $proformas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $centrosVenta = CentroVenta::getAllActive();
      $clientes = ClienteIntl::getAllActive();
      $clientes->load('formaPago');
      $clausulas = ClausulaVenta::getAllActive();
      $transportes = MedioTransporte::getAllActive();
      $productos = Producto::getAllActive();
      $aduanas = Aduana::getAllActive();

      return view('comercial.proforma.create')->with([
        'centrosVenta' => $centrosVenta,
        'clientes' => $clientes,
        'clausulas' => $clausulas,
        'transportes' => $transportes,
        'aduanas' => $aduanas,
        'productos' => $productos
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function show(Proforma $proforma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function edit(Proforma $proforma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proforma $proforma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proforma $proforma)
    {
        //
    }
}
