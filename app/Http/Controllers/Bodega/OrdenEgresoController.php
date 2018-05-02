<?php

namespace App\Http\Controllers\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PDF;
use Carbon\Carbon;
use App\Models\Bodega\Bodega;
use App\Models\Bodega\OrdenEgreso;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;

class OrdenEgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        $ordenes = OrdenEgreso::orderBy('numero','desc')->take(20)->get();

        $ordenes = $ordenes->map(function($orden) {

            $orden->load('documento.cliente');
            return $orden;
        });

        return view('bodega.ordenEgreso.index')->with(['ordenes' => $ordenes]);
    }

    public function pendingOrdenEgreso() {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        $proformas = Proforma::where('numero',11020)->get();

        $proformas->map(function ($proforma) use($tipoProforma){

            $proforma['tipo_id'] = $tipoProforma;
            $proforma['tipo'] = 'proforma';

            return $proforma;
        });

        $notasVenta = NotaVenta::getAllAuthorizedNotProcessed();
        $notasVenta->map(function ($notaVenta) use($tipoNotaVenta){

            $notaVenta['tipo_id'] = $tipoNotaVenta;
            $notaVenta['tipo'] = 'nota Venta';

            return $notaVenta;
        });

        $ordenes = $proformas->sortBy('created_at');

        return view('bodega.ordenEgreso.pendingOrdenEgreso')->with(['ordenes' => $ordenes]);
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

    public function createEgresoManualMP() {

        $productos = Bodega::getStockOfMPFromBodega();
        $fecha = Carbon::now()->toDateString();

        return view('bodega.ordenEgreso.createEgresoManualMP')->with(['productos' => $productos, 'fecha' => $fecha]);
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
            'tipo' => 'required',
            'id' => 'required',
        ]);

        $bodega = intval($request->bodega);
        $tipo = intval($request->tipo);
        $id = intval($request->id);
        $user = $request->user()->id;

        $ordenEgreso = OrdenEgreso::generate($user,$tipo,$id,$bodega);

        return redirect()->route('verOrdenEgreso', ['numero' => $ordenEgreso->numero]);
    }

    public function storeEgresoManualMP(Request $request)
    {
        $this->validate($request,[
            'tipo' => 'required',
            'id' => 'required',
        ]);

        $bodega = intval($request->bodega);
        $tipo = intval($request->tipo);
        $id = intval($request->id);
        $user = $request->user()->id;

        $ordenEgreso = OrdenEgreso::generate($user,$tipo,$id,$bodega);

        return redirect()->route('verOrdenEgreso', ['numero' => $ordenEgreso->numero]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bodega\OrdenEgreso  $ordenEgreso
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $ordenEgreso = OrdenEgreso::where('numero',$numero)->first();

        $ordenEgreso->load('documento');
        $ordenEgreso->detalles->load('item');

        if (!$ordenEgreso) {

            dd('Orden Egreso no existe...');
        }

        return view('bodega.ordenEgreso.show')->with(['ordenEgreso' => $ordenEgreso]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bodega\OrdenEgreso  $ordenEgreso
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenEgreso $ordenEgreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bodega\OrdenEgreso  $ordenEgreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenEgreso $ordenEgreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bodega\OrdenEgreso  $ordenEgreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenEgreso $ordenEgreso)
    {
        //
    }

    public function pdf($numero) {

        $ordenEgreso = OrdenEgreso::where('numero',$numero)->first();
        $ordenEgreso->load('documento.cliente');
        $ordenEgreso->tipo();
        dd($ordenEgreso);
    }
    public function downloadPDF($numero) {

        $ordenEgreso = OrdenEgreso::where('numero',$numero)->first();
        $ordenEgreso->load('documento.cliente','detalles.item');
        $ordenEgreso->tipo();
        $pdf = PDF::loadView('bodega.ordenEgreso.pdf',compact('ordenEgreso'));

        return $pdf->stream('Orden Egreso N°'.$ordenEgreso->numero.'.pdf');
    }

    public function consultExistence(Request $request) {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        $bodegas = Bodega::getAllActive();
        $documento = [];

        $this->validate($request,[
            'tipo' => 'required',
            'id' => 'required',
        ]);

        if ($tipoProforma == $request->tipo) {

            $documento = Proforma::with('detalles')->where('id',$request->id)->first();
            $documento->tipo_id = $tipoProforma;
            $documento->tipo = 'Proforma';
        }
        else if ($tipoNotaVenta == $request->tipo) {

            $documento = NotaVenta::with('detalles')->where('id',$request->id)->first();
            $documento->tipo_id = $tipoNotaVenta;
            $documento->tipo = 'Nota de Venta';
        }

        return view('bodega.ordenEgreso.consultExistence')->with(['documento' => $documento, 'bodegas' => $bodegas]);
    }

    // api
    public function checkExistence(Request $request) {

        $tipoProforma  = config('globalVars.TDP');
        $tipoNotaVenta = config('globalVars.TDNV');

        $tipoDoc = $request->tipoDoc;
        $docId = $request->docId;
        $bodega = $request->bodega;

        if ($tipoDoc == $tipoProforma) {

            $documento = Proforma::with('detalles')->where('id',$docId)->first();

        } else if ($tipoDoc == $tipoNotaVenta) {

            $documento = NotaVenta::with('detalles')->where('id',$docId)->first();
        }

        $items = $documento->detalles;

        $items->map(function($item) use($bodega) {

            $existencia = Bodega::getExistTotalPT($item->producto_id,$bodega);
            $item['existencia'] = $existencia;
        });

        return response($items,200);
    }
}
