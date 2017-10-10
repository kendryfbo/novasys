<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\NotaDebitoIntl;
use App\Models\Comercial\NotaCreditoIntl;

class NotaDebitoIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notasDebito = NotaDebitoIntl::all();

        return view('comercial.notaDebitoIntl.index')->with(['notasDebito' => $notasDebito]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->notaCredito) {

            $notaCredito = NotaCreditoIntl::with('detalles')->where('numero', $request->notaCredito)->first();

        } else {

            $notaCredito = '';
        }

        return view('comercial.notaDebitoIntl.create')->with(['notaCredito' => $notaCredito]);
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
            'numero' => 'required',
            'notaCredito' => 'required',
            'fecha' => 'required'
        ]);

        $notaCredito = NotaCreditoIntl::where('numero',$request->notaCredito)->first();

        NotaDebitoIntl::create([
            'numero' => $request->numero,
            'num_nc' => $notaCredito->numero,
            'nota' => $request->nota,
            'fecha' => $request->fecha,
            'fob' => $notaCredito->neto,
            'total' => $notaCredito->total,
            'user_id' => $request->user()->id
        ]);

        $msg = 'Nota Debito N°' . $request->numero . " Ha sido Creada";

        return redirect()->route('notaDebitoIntl')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\NotaDebitoIntl  $notaDebitoIntl
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $notaDebitoIntl = NotaDebitoIntl::where('numero',$numero)->first();

        $notaCredito = NotaCreditoIntl::with('detalles')->where('numero',$notaDebitoIntl->num_nc)->first();
        $factura = FacturaIntl::where('numero',$notaCredito->num_fact)->first();

        return view('comercial.notaDebitoIntl.show')->with(['notaCredito' => $notaCredito, 'factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\NotaDebitoIntl  $notaDebitoIntl
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaDebitoIntl $notaDebitoIntl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\NotaDebitoIntl  $notaDebitoIntl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaDebitoIntl $notaDebitoIntl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\NotaDebitoIntl  $notaDebitoIntl
     * @return \Illuminate\Http\Response
     */
    public function destroy($notaDebitoIntl)
    {
        $notaDebitoIntl = NotaDebitoIntl::find($notaDebitoIntl);

        $notaDebitoIntl->delete();
        
        $msg = 'Nota Debito N°' . $notaDebitoIntl->numero . " Ha sido Eliminada.";

        return redirect()->route('notaDebitoIntl')->with(['status' => $msg]);
    }
}
