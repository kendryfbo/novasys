<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Comercial\Proforma;
use App\Http\Controllers\Controller;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\ClausulaVenta;
use App\Models\Comercial\PuertoEmbarque;
use App\Models\Comercial\MedioTransporte;

class ProformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $proformas = Proforma::with('cliente')->orderBy('numero','desc')->take(20)->get();

      return view('comercial.proforma.index')->with(['proformas' => $proformas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $productos = Producto::getAllActive();
      $clientes = ClienteIntl::with('formaPago','sucursales')->where('activo',1)->get();
      $clausulas = ClausulaVenta::getAllActive();
      $centrosVenta = CentroVenta::getAllActive();
      $transportes = MedioTransporte::getAllActive();
      $puertoEmbarque = PuertoEmbarque::getAllActive();

      return view('comercial.proforma.create')->with([
        'centrosVenta' => $centrosVenta,
        'clientes' => $clientes,
        'clausulas' => $clausulas,
        'transportes' => $transportes,
        'puertoEmbarque' => $puertoEmbarque,
        'productos' => $productos
      ]);
    }

    /**
     * Show the form for creating a new resource from Import.
     *
     * @return \Illuminate\Http\Response
     */
    public function createImport(Request $request)
    {
        $numero = $request->proforma;
        $proforma = Proforma::with('detalles')->where('numero',$numero)->first();

        if (!$proforma) {

            return redirect()->back();
        }

        $centrosVenta = CentroVenta::getAllActive();
        $clientes = ClienteIntl::getAllActive();
        $clientes->load('formaPago');
        $clausulas = ClausulaVenta::getAllActive();
        $transportes = MedioTransporte::getAllActive();
        $productos = Producto::getAllActive();
        $puertoEmbarque = PuertoEmbarque::getAllActive();

        return view('comercial.proforma.createImport')->with([
            'proforma' => $proforma,
            'centrosVenta' => $centrosVenta,
            'clientes' => $clientes,
            'clausulas' => $clausulas,
            'transportes' => $transportes,
            'puertoEmbarque' => $puertoEmbarque,
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
        //dd($request->all());
      $this->validate($request, [
        'centroVenta' => 'required',
        'numero' => 'required',
        'version' => 'required',
        'emision' => 'required',
        'clausula' => 'required',
        'semana' => 'required',
        'cliente' => 'required',
        "transporte" => 'required',
        'puertoE' => 'required',
        'formaPago' => 'required',
        'direccion' => 'required',
        'puertoD' => 'required'
      ]);

      $numero = Proforma::register($request);

      $msg = "Proforma N°". $numero . " ha sido Creada.";

      return redirect(route('proforma'))->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
      $proforma = Proforma::with('detalles')->where('numero',$numero)->first();

      return view('comercial.proforma.show')->with(['proforma' => $proforma]);
    }

    public function showForAut($numero)
    {
      $proforma = Proforma::with('detalles')->where('numero',$numero)->first();

      return view('comercial.proforma.authorize')->with(['proforma' => $proforma]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function edit($proforma)
    {
        $proforma = Proforma::with('detalles')->where('numero',$proforma)->first();

        if (!$proforma || $proforma->aut_contab) {

            return redirect()->back();
        }

        $centrosVenta = CentroVenta::getAllActive();
        $clientes = ClienteIntl::getAllActive();
        $clientes->load('formaPago');
        $clausulas = ClausulaVenta::getAllActive();
        $transportes = MedioTransporte::getAllActive();
        $productos = Producto::getAllActive();
        $puertoEmbarque = PuertoEmbarque::getAllActive();

        return view('comercial.proforma.edit')->with([
            'proforma' => $proforma,
            'centrosVenta' => $centrosVenta,
            'clientes' => $clientes,
            'clausulas' => $clausulas,
            'transportes' => $transportes,
            'puertoEmbarque' => $puertoEmbarque,
            'productos' => $productos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\Proforma  $proforma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $proforma)
    {
        $this->validate($request, [
          'centroVenta' => 'required',
          'numero' => 'required',
          'version' => 'required',
          'emision' => 'required',
          'clausula' => 'required',
          'semana' => 'required',
          'cliente' => 'required',
          "transporte" => 'required',
          'puertoE' => 'required',
          'formaPago' => 'required',
          'direccion' => 'required',
          'puertoD' => 'required'
        ]);

        $numero = Proforma::edit($request,$proforma);

        $msg = "Proforma N°". $numero . " ha sido Modificada.";

        return redirect(route('proforma'))->with(['status' => $msg]);
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

    /* Lista de Proformas Por Autorizar */
    public function authorization() {

        $proformas = Proforma::getAllUnathorized();

        return view('comercial.proforma.authorization')->with(['proformas' => $proformas]);
    }

    public function auth(Proforma $proforma) {

        $proforma->authorizeComer();

        $msg = 'Proforma N°' . $proforma->numero . ' Ha sido Autorizada.';

        return redirect()->route('autorizacionProforma')->with(['status' => $msg]);
    }

    public function unauth(Proforma $proforma) {

        $proforma->unauthorizeComer();

        $msg = 'Proforma N°' . $proforma->numero . ' No ha sido Autorizada.';

        return redirect()->route('autorizacionProforma')->with(['status' => $msg]);
    }

}
