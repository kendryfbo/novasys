<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Comercial\Aduana;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\GuiaDespacho;
use App\Models\Comercial\PuertoEmbarque;

class GuiaDespachoController extends Controller
{

  public function index() {

    $guias = GuiaDespacho::with('proforma:id,numero,cliente', 'aduana:id,descripcion')->orderBy('numero')->take(20)->get();
    return view('comercial.guiaDespacho.index')->with(['guias' => $guias]);
  }

  public function show($guia) {

    $guia = GuiaDespacho::with('detalles','proforma:id,numero', 'aduana:id,descripcion')->where('numero',$guia)->first();

    return view('comercial.guiaDespacho.show')->with(['guia' => $guia]);
  }

  public function create(Request $request) {

    $proforma = Proforma::with('detalles')->where('numero',$request->proforma)->first();
    $aduanas = Aduana::getAllActive();
    $puertosEmbarque = PuertoEmbarque::getAllActive();

    return view('comercial.guiaDespacho.create')->with(
        ['proforma' => $proforma, 'aduanas' => $aduanas, 'puertosEmbarque' => $puertosEmbarque]);
  }

  public function store(Request $request) {

    $this->validate($request,[
      'proforma' => 'required',
      'numero' => 'required',
      'aduana' => 'required',
      'fecha' => 'required',
      'mn' => 'required',
      'booking' => 'required',
      'contenedor' => 'required',
      'sello' => 'required',
      'chofer' => 'required',
      'patente' => 'required',
      'movil' => 'required',
      'prof' => 'required',
      'dus' => 'required',
      'neto' => 'required',
      'bruto' => 'required'
    ]);

    $guia = guiaDespacho::register($request);

    $msg = 'Guia Despacho N°' . $guia->numero . ' Ha sido Creada.';

    return redirect(route('guiaDespacho'))->with(['status' => $msg]);
  }

    public function destroy(GuiaDespacho $guia) {

        $guia->delete();

        $msg = 'Guia Despacho N°' . $guia->numero . ' ha sido Eliminada.';

        return redirect()->route('guiaDespacho')->with('status', $msg);
    }

  public function pdf($guia) {

      return redirect()->back();
    $datos = [];

    $pdf = PDF::loadView('documents.pdf.guiaDespacho', $datos);
  }
}
