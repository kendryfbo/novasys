<?php

namespace App\Http\Controllers\Comercial;

use Excel;
use Illuminate\Http\Request;
use App\Models\Comercial\Proforma;
use App\Http\Controllers\Controller;
use App\Models\Comercial\FacturaIntl;
use App\Events\CreateFacturaIntlEvent;

class FacturaIntlController extends Controller
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
      $centrosVenta = [];
      $clientes = [];
      $clausulas = [];
      $transportes = [];
      $productos = [];
      $aduanas = [];

      return view('comercial.facturaIntl.create')->with([
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
      dd('guardar Factura Int.');
    }

    public function storeFromProforma(Request $request, $proforma)
    {

      $factura = FacturaIntl::regFromProforma($request,$proforma);
      //event(new CreateFacturaIntlEvent($factura));

      return redirect()->route('verFacturaIntl',['facturaIntl' => $factura]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function show(FacturaIntl $facturaIntl)
    {
      $facturaIntl->load('detalles');

      return view('comercial.facturaIntl.show')->with(['factura' => $facturaIntl]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function edit(FacturaIntl $facturaIntl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacturaIntl $facturaIntl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacturaIntl $facturaIntl)
    {
        //
    }

    public function importProforma(Request $request) {

      $proforma = Proforma::with('detalles')->where('numero',$request->proforma)->first();

      if (!$proforma) {

        $msg = 'Proforma No existe';

        return redirect()->back()->with(['status' => $msg]);
      }

      return view('comercial.facturaIntl.createFromProforma')->with(['proforma' => $proforma]);
    }

    /* DESCARGAR Factura Internacional */
    public function download($facturaIntl) {

      $factura = facturaIntl::with('detalles')->find($facturaIntl);
      return Excel::create('Factura_'.$factura->numero, function($excel) use ($factura) {
        $excel->sheet('New sheet', function($sheet) use ($factura) {
          $sheet->loadView('documents.excel.facturaIntl')
                ->with('factura', $factura);
          })->download('xlsx');
      });
    }

}
