<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\NotaDebitoNac;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\Impuesto;
use App\Models\Comercial\CentroVenta;

class NotaDebitoNacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notasDebito = NotaDebitoNac::all();

        return view('comercial.notaDebitoNac.index')->with(['notasDebito' => $notasDebito]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $IVA = Impuesto::where([['id','1'],['nombre','iva']])->pluck('valor')->first();
        $IABA = Impuesto::where([['id','2'],['nombre','iaba']])->pluck('valor')->first();
        $busqueda = $request;
        $centrosVentas = CentroVenta::getAllActive();
        $numeroFactura = $request->factura;
        if ($numeroFactura) {

            $factura = FacturaNacional::with('detalles','clienteNac')->where('numero', $numeroFactura)->where('cv_id',$request->centrosVentas)->first();

        } else {

            $factura = [];
        }

        return view('comercial.notaDebitoNac.create')->with(['factura' => $factura, 'iva' => $IVA, 'iaba' => $IABA, 'busqueda' => $busqueda, 'centrosVentas' => $centrosVentas]);
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
        $this->validate($request,[
            'numero' => 'required',
            'facturaID' => 'required',
            'fecha' => 'required',
            'items' => 'required'
        ]);

        $notaDebito = NotaDebitoNac::register($request);

        $msg = 'Nota Debito N°' . $notaDebito->numero . " Ha sido Creada";

        return redirect()->route('notaDebitoNac')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\NotaDebitoNac  $notaDebitoNac
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $notaDebitoNac = NotaDebitoNac::where('numero',$numero)->first();
        $factura = FacturaNacional::where('id',$notaDebitoNac->factura_id)->first();
        $IVA = Impuesto::where([['id','1'],['nombre','iva']])->pluck('valor')->first();
        $IABA = Impuesto::where([['id','2'],['nombre','iaba']])->pluck('valor')->first();


        return view('comercial.notaDebitoNac.show')->with(['notaDebitoNac' => $notaDebitoNac, 'factura' => $factura, 'iva' => $IVA, 'iaba' => $IABA]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\NotaDebitoNac  $notaDebitoNac
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaDebitoNac $notaDebitoNac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\NotaDebitoNac  $notaDebitoNac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaDebitoNac $notaDebitoNac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\NotaDebitoNac  $notaDebitoNac
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaDebitoNac $notaDebito)
    {
        $notaDebito->delete();

        $msg = 'Nota Debito N°' . $notaDebito->numero . " Ha sido Eliminada.";

        return redirect()->route('notaDebitoNac')->with(['status' => $msg]);
    }
}
