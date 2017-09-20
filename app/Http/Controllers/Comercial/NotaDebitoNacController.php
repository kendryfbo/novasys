<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\NotaDebitoNac;
use App\Models\Comercial\NotaCreditoNac;

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
        if ($request->notaCredito) {

            $notaCredito = NotaCreditoNac::with('detalles')->where('numero', $request->notaCredito)->first();

        } else {

            $notaCredito = '';
        }

        return view('comercial.notaDebitoNac.create')->with(['notaCredito' => $notaCredito]);
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

        $notaCredito = NotaCreditoNac::where('numero',$request->notaCredito)->first();

        NotaDebitoNac::create([
            'numero' => $request->numero,
            'num_nc' => $notaCredito->numero,
            'nota' => $request->nota,
            'fecha' => $request->fecha,
            'neto' => $notaCredito->neto,
            'iaba' => $notaCredito->iaba,
            'iva' => $notaCredito->iva,
            'total' => $notaCredito->total,
            'user_id' => $request->user()->id
        ]);

        $msg = 'Nota Debito N°' . $request->numero . " Ha sido Creada";

        return redirect()->route('notaDebitoNac')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\NotaDebitoNac  $notaDebitoNac
     * @return \Illuminate\Http\Response
     */
    public function show(NotaDebitoNac $notaDebitoNac)
    {
        //
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
