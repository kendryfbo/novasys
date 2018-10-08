<?php

namespace App\Http\Controllers\Comercial;

use PDF;
use Excel;
use Carbon\Carbon;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Comercial\Proforma;
use App\Http\Controllers\Controller;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ClienteIntl;
use App\Events\CreateFacturaIntlEvent;
use App\Models\Comercial\ClausulaVenta;
use App\Models\Comercial\PuertoEmbarque;
use App\Models\Comercial\MedioTransporte;

class FacturaIntlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = FacturaIntl::orderBy('created_at','desc')->get();

        return view('comercial.facturaIntl.index')->with(['facturas' => $facturas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productoMatEnvase = 623;
        $productos = Producto::where('id',$productoMatEnvase)->get();
        $clientes = ClienteIntl::with('formaPago','sucursales')->where('activo',1)->get();
        $clausulas = ClausulaVenta::getAllActive();
        $centrosVenta = CentroVenta::getAllActive();
        $transportes = MedioTransporte::getAllActive();
        $puertoEmbarques = PuertoEmbarque::getAllActive();

        $fecha = Carbon::now()->format('Y-m-d');

      return view('comercial.facturaIntl.create')->with([
        'centrosVenta' => $centrosVenta,
        'clientes' => $clientes,
        'clausulas' => $clausulas,
        'transportes' => $transportes,
        'puertoEmbarques' => $puertoEmbarques,
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
        //dd($request->all());
        $this->validate($request, [
          'centroVenta' => 'required',
          'numero' => 'required',
          'emision' => 'required',
          'clausula' => 'required',
          'clienteId' => 'required',
          'clienteDescrip' => 'required',
          "transporte" => 'required',
          'puertoE' => 'required',
          'formaPago' => 'required',
          'direccion' => 'required',
          'despacho' => 'required',
          'puertoD' => 'required'
        ]);

        if (FacturaIntl::where('numero',$request->numero)->first()) {

            $msg = 'Numero de Factura ya existe.';

            return redirect()->route('FacturaIntl')->with(['status' => $msg]);
        }

        $date = new Carbon($request->emision);
        $date->addDays($request->diasFormaPago);
        $date = $date->format('Y-m-d');
        $request->vencimiento = $date;

        $factura = FacturaIntl::register($request);
        $msg = 'Factura N°' . $factura->numero . ' ha sido creada.';

        return redirect()->route('FacturaIntl')->with(['status' => $msg]);
    }

    public function storeFromProforma(Request $request, $proforma)
    {

        if (FacturaIntl::where('numero',$request->numero)->first()) {

            $msg = 'Numero de Factura ya existe.';

            return redirect()->route('FacturaIntl')->with(['status' => $msg]);
        }

        $date = new Carbon($request->emision);
        $date->addDays($request->diasFormaPago);
        $date = $date->format('Y-m-d');
        $request->vencimiento = $date;


        $factura = FacturaIntl::regFromProforma($request,$proforma);
        //event(new CreateFacturaIntlEvent($factura));

        $msg = 'Factura N°' . $factura->numero . ' ha sido creada.';

        return redirect()->route('FacturaIntl')->with(['status' => $msg]);
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
    public function edit($numero)
    {
        $factura = FacturaIntl::with('detalles','clienteIntl.formaPago')->where('numero',$numero)->first();

        return view('comercial.facturaIntl.edit')->with(['factura' => $factura]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FacturaIntl  $facturaIntl
     * @return \Illuminate\Http\Response
     */
    public function update( FacturaIntl $facturaIntl,Request $request)
    {
        $this->validate($request,[
            'numero' => 'required',
            'emision' => 'required',
            'nota' => 'required',
            'diasFormaPago' => 'required',
        ]);

        $date = new Carbon($request->emision);
        $date->addDays($request->diasFormaPago);
        $date = $date->format('Y-m-d');
        $request->vencimiento = $date;

        $factura = FacturaIntl::registerEdit($request,$facturaIntl);

        $msg = 'Factura Internacional Nº' . $factura->numero . ' Ha sido Modificada.';

        return redirect()->route('FacturaIntl')->with(['status' => $msg]);
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
        $proforma = Proforma::where('factura',$factura->numero)->first();

        $proforma->factura = NULL;
        $proforma->save();
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
    } else if (!$proforma->isAuthorized()) {

        $msg = 'Proforma no se encuentra autorizada.';
        return redirect()->back()->with(['status' => $msg]);

    } else if ($proforma->factura) {

        $msg = 'Proforma ya se encuentra relacionada a la factura Nº'.$proforma->factura.'.';
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
    /* DESCARGAR Factura Internacional PDF */
    public function downloadPDF($id) {

        $factura = FacturaIntl::with('centroVenta','proformaInfo','clienteIntl','detalles.producto.marca','detalles.producto.formato','detalles.producto.sabor')->find($id);
        $date = new Carbon($factura->fecha_emision);
        $date = $date->format('d/m/Y');
        $factura->fecha_emision_formato_correcto = $date;

        //return view('comercial.facturaIntl.facturaIntlPDF')->with(['factura' => $factura]);
        $pdf = PDF::loadView('comercial.facturaIntl.facturaIntlPDF',compact('factura'));

        return $pdf->stream();
    }
    /* DESCARGAR Factura Internacional SII PDF */
    public function downloadSIIPDF($id) {

        $factura = FacturaIntl::with('centroVenta','clienteIntl','detalles.producto.marca','detalles.producto.formato','detalles.producto.sabor')->find($id);

        $date = new Carbon($factura->fecha_emision);
        $day = $date->format('d');
        $month = $date->format('m');
        $year = $date->format('y');
        $date = $date->format('d/m/Y');

        $factura->fecha_emision_formato_correcto = $date;
        $factura->day = $day;
        $factura->month = $month;
        $factura->year = $year;

        $pdf = PDF::loadView('comercial.facturaIntl.facturaIntlSIIPDF',compact('factura'));

        return $pdf->stream();
    }

}
