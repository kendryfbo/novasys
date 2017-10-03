<?php

namespace App\Http\Controllers\Comercial;

use Excel;
use Carbon\Carbon;
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
        $facturas = FacturaIntl::orderBy('numero')->take(20)->get();

        return view('comercial.facturaIntl.index')->with(['facturas' => $facturas]);
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

        /*
        $this->validate($request,[
            "numero" => "required",
            "proforma" => "required",
            "emision" => "required",
            "diasFormaPago" => "required",
            "direccion" => "required",
            "nota" => "required"
        ]);
        */

        $date = new Carbon($request->emision);
        $date->addDays($request->diasFormaPago);
        $date = $date->format('Y-m-d');
        $request->vencimiento = $date;

        $factura = FacturaIntl::regFromProforma($request,$proforma);
        //event(new CreateFacturaIntlEvent($factura));

        $msg = 'Factura N°' . $factura->numero . ' ha sido creada.';

        return redirect()->route('FacturaIntl');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $factura = FacturaIntl::with('detalles')->where('numero', $numero)->first();

        return view('comercial.facturaIntl.show')->with(['factura' => $factura]);
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
    public function destroy($numero)
    {
        $factura = FacturaIntl::where('numero', $numero)->first();

        $factura->delete();

        $msg = 'Factura N°' . $factura->numero . ' ha sido eliminada.';

        return redirect()->route('FacturaIntl')->with(['status' => $msg]);
    }

    /* Facturar apartir de importacion de proforma */
    public function importProforma(Request $request) {

      $proforma = Proforma::with('detalles','clienteIntl.formaPago')->where('numero',$request->proforma)->first();

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
