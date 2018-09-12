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

    if (!$factura) {
        dd('Factura # '. $numero . ' No Existe.');
    }
    $pdf = PDF::loadView('documents.pdf.packingList',compact('guia','factura'))->setPaper('a4','landscape');


    return $pdf->stream();
  }
}
