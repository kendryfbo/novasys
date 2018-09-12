<?php

namespace App\Http\Controllers\Comercial;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\GuiaDespacho;

class PackingListController extends Controller
{

  public function create(Request $request) {

    $guia = GuiaDespacho::with('detalles.producto.formato')->where('numero',$request->guia)->first();

    return view('comercial.packingList.create')->with(['guia' => $guia]);
  }

  public function pdf(Request $request) {

    $this->validate($request, [
      'guia' => 'required',
      'factura' => 'required'
    ]);

    $guiaID = $request->guia;
    $numero = $request->factura;

    $factura = FacturaIntl::with('detalles')->where('numero',$numero)->first();
    $guia = GuiaDespacho::with('detalles.producto.formato')->where('id',$guiaID)->first();

    $pesoNetoTotal = 0;
    $pesoBrutoTotal = 0;
    $pesoVolumenTotal = 0;

    foreach ($guia->detalles as $detalle) {
        $pesoNetoTotal += $detalle->cantidad * $detalle->producto->peso_neto;
        $pesoBrutoTotal += $detalle->cantidad * $detalle->producto->peso_bruto;
        $pesoVolumenTotal += $detalle->cantidad * $detalle->producto->volumen;

    }

    $guia->peso_neto_total = $pesoNetoTotal;
    $guia->peso_bruto_total = $pesoBrutoTotal;
    $guia->volumen_total = $pesoVolumenTotal;

    if (!$factura) {
        dd('Factura # '. $numero . ' No Existe.');
    }
    $pdf = PDF::loadView('documents.pdf.packingList',compact('guia','factura'))->setPaper('a4','landscape');


    return $pdf->stream();
  }
}
