<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Models\Comercial\Impuesto;
use App\Http\Controllers\Controller;
use App\Models\Comercial\NotaCreditoNac;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FacturaNacionalDetalle;

class NotaCreditoNacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notasCredito = NotaCreditoNac::orderBy('numero')->take(20)->get();

        return view('comercial.notaCreditoNac.index')->with(['notasCredito' => $notasCredito]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $factura = FacturaNacional::where('numero',$request->factura)->first();

        if ($factura) {

            $factura->iaba = Impuesto::find(2)->valor; // buscar valor impuesto iaba Id:2
            $detalles = $factura->detalles->load('producto.marca');

            // Determinar si producto posee iaba o no y agregarlo al detalle
            foreach ($detalles as $key => $detalle) {

                if ($detalle->producto->marca->iaba) {

                    $factura->detalles[$key]->iaba = 1;

                } else {

                    $factura->detalles[$key]->iaba = 0;
                }
            }

        } else {

            $factura = '';
        }


        return view('comercial.notaCreditoNac.create')->with(['factura' => $factura]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createToCliente() {

        $clientes = ClienteNacional::getAllActive();

        return view('comercial.notaCreditoNac.createForCliente')->with(['clientes' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $this->validate($request,[
            'numero' => 'required',
            'factura' => 'required',
            'fecha' => 'required',
            'cliente' => 'required',
            'formaPago' => 'required',
            'items' => 'required'
        ]);

        NotaCreditoNac::register($request);

        $msg = 'Nota de Credito N°'. $request->numero . ' ha sido creada.';

        return redirect()->route('notaCreditoNac')->with(['status' => $msg]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeToCliente(Request $request)
    {
        $datos = $this->validate($request,[
            'numero' => 'required',
            'fecha' => 'required',
            'cliente' => 'required',
            'items' => 'required'
        ]);

        NotaCreditoNac::register($request);

        $msg = 'Nota de Credito N°'. $request->numero . ' ha sido creada.';

        return redirect()->route('notaCreditoNac')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\NotaCreditoNac  $notaCredito
     * @return \Illuminate\Http\Response
     */
    public function show($notaCredito)
    {
        $notaCredito = NotaCreditoNac::with('detalles')->where('numero',$notaCredito)->first();

        return view('comercial.notaCreditoNac.show')->with(['notaCredito' => $notaCredito]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\NotaCreditoNac  $notaCredito
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaCreditoNac $notaCredito)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\NotaCreditoNac  $notaCredito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaCreditoNac $notaCredito)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\NotaCreditoNac  $notaCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaCreditoNac $notaCredito)
    {
        $notaCredito->delete();

        $msg = 'Nota Credito N°'. $notaCredito->numero . ' ha sido Eliminada.';

        return redirect()->route('notaCreditoNac')->with(['status' => $msg]);
    }

    public function authorization() {

        $notasCredito = NotaCreditoNac::getAllUnauthorized();

        return view('comercial.notaCreditoNac.authorization')->with(['notasCredito' => $notasCredito]);
    }

    public function auth(NotaCreditoNac $notaCredito) {

        $notaCredito->authorize();

        $msg = "Nota Credito N°" . $notaCredito->numero . " ha sido Autorizada";

        return redirect()->route('autorizacionNotaCreditoNac')->with(['status' => $msg]);
    }

    public function unauth(NotaCreditoNac $notaCredito) {

        $notaCredito->unauthorize();

        $msg = "Nota Credito N°" . $notaCredito->numero . " ha sido No autorizada";

        return redirect()->route('autorizacionNotaCreditoNac')->with(['status' => $msg]);
    }
}
