<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\NotaCreditoIntl;

class NotaCreditoIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notasCredito = NotaCreditoIntl::orderBy('numero')->take(20)->get();

        return view('comercial.notaCreditoIntl.index')->with(['notasCredito' => $notasCredito]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $factura = FacturaIntl::with('detalles')->where('numero',$request->factura)->first();

        return view('comercial.notaCreditoIntl.create')->with(['factura' => $factura]);
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
            'items' => 'required'
        ]);

        NotaCreditoIntl::register($request);

        $msg = 'Nota de Credito N°'. $request->numero . ' ha sido creada.';

        return redirect()->route('notaCreditoIntl')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\NotaCreditoIntl  $notaCreditoIntl
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $notaCredito = NotaCreditoIntl::with('detalles')->where('numero',$numero)->first();
        $factura = FacturaIntl::where('numero',$notaCredito->num_fact)->first();

        return view('comercial.notaCreditoIntl.show')
            ->with(['notaCredito' => $notaCredito, 'factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\NotaCreditoIntl  $notaCreditoIntl
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaCreditoIntl $notaCreditoIntl)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\NotaCreditoIntl  $notaCreditoIntl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaCreditoIntl $notaCreditoIntl)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\NotaCreditoIntl  $notaCreditoIntl
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaCreditoIntl $notaCreditoIntl)
    {
        dd('destroy');
    }
}
