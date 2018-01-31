<?php

namespace App\Http\Controllers\Adquisicion;

use PDF;
use App\Models\Insumo;
use App\Models\Finanzas\Moneda;
use App\Models\Adquisicion\Area;
use App\Models\Comercial\Impuesto;
use App\Models\Comercial\CentroVenta;
use App\Models\Adquisicion\Proveedor;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Adquisicion\OrdenCompraTipo;
use App\Models\Adquisicion\OrdenCompraDetalle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdenCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenesCompra = OrdenCompra::with('proveedor.formaPago','area','status','tipo')->orderBy('numero','desc')->take(20)->get();

        return view('adquisicion.ordenCompra.index')->with(['ordenesCompra' => $ordenesCompra]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::getAllActive();
        $monedas = Moneda::getAllActive();
        $materiaPrima = Insumo::getArrayOfAllActiveWithLastPrice();
        $tipos = OrdenCompraTipo::getAllActive();
        $proveedores = Proveedor::getAllActive()->load('formaPago');
        $iva = Impuesto::where('nombre','iva')->pluck('valor')->first();

        return view('adquisicion.ordenCompra.create')->with([
            'tipos' => $tipos,
            'monedas' => $monedas,
            'proveedores' => $proveedores,
            'areas' => $areas,
            'productos' => $materiaPrima,
            'iva' => $iva,
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
        $this->validate($request,[
            'numero' => 'required',
            'prov_id' => 'required',
            'area_id' => 'required',
            'contacto' => 'required',
            'forma_pago' => 'required',
            'fecha_emision' => 'required',
            'moneda' => 'required',
            'porc_desc' => 'required',
            'tipo' => 'required',
            'impuesto' => 'required',
        ]);

        $ordenCompra = OrdenCompra::register($request);

        $msg = 'Orden de compra N°' . $ordenCompra->numero . ' Ha sido Creada';

        return redirect()->route('ordenCompra')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adquisicion\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {

        $ordenCompra = OrdenCompra::with('proveedor', 'area', 'tipo', 'detalles')->where('numero',$numero)->first();

        return view('adquisicion.ordenCompra.show')->with(['ordenCompra' => $ordenCompra]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adquisicion\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function edit($numero)
    {
        $ordenCompra = OrdenCompra::with('detalles')->where('numero',$numero)->first();

        if ($ordenCompra->aut_contab) {

            $msg = 'Orden Compra Numero N°' . $ordenCompra->numero . ' Ya ha sido Autorizada, no se puede modificar.';
            return redirect()->route('ordenCompra')->with(['status' => $msg]);
        }

        // Por Implementar
        $ordenCompra->porcDesc = $ordenCompra->descuento ? (($ordenCompra->descuento * 100) / $ordenCompra->sub_total) : 0;

        $areas = Area::getAllActive();
        $monedas = Moneda::getAllActive();
        $materiaPrima = Insumo::getArrayOfAllActiveWithLastPrice();
        $tipos = OrdenCompraTipo::getAllActive();
        $proveedores = Proveedor::getAllActive()->load('formaPago');
        $iva = Impuesto::where('nombre','iva')->pluck('valor')->first();

        return view('adquisicion.ordenCompra.edit')->with([
            'ordenCompra' => $ordenCompra,
            'tipos' => $tipos,
            'monedas' => $monedas,
            'proveedores' => $proveedores,
            'areas' => $areas,
            'productos' => $materiaPrima,
            'iva' => $iva,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adquisicion\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenCompra $ordenCompra)
    {

        $this->validate($request,[
            'numero' => 'required',
            'prov_id' => 'required',
            'area_id' => 'required',
            'contacto' => 'required',
            'forma_pago' => 'required',
            'fecha_emision' => 'required',
            'moneda' => 'required',
            'porc_desc' => 'required',
            'tipo' => 'required',
            'impuesto' => 'required',
        ]);

        $ordenCompra = OrdenCompra::registerEdit($request,$ordenCompra);
        $msg = 'Orden de Compra Nº' . $ordenCompra->numero . ' Ha sido Modificada.';

        return redirect()->route('ordenCompra')->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adquisicion\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenCompra $ordenCompra)
    {
        $ordenCompra->delete();
        $msg = "Orden Compra Nº". $ordenCompra->numero . " ha sido Eliminada";
        return redirect()->route('ordenCompra')->with(['status' => $msg]);
    }

    public function complete(OrdenCompra $ordenCompra) {

        $ordenCompra->complete();
        $msg = 'Orden Compra N°' . $ordenCompra->numero . ' Completa.';

        return redirect()->route('ordenCompra')->with(['status' => $msg]);
    }

    public function incomplete(OrdenCompra $ordenCompra) {

        $ordenCompra->incomplete();
        $msg = 'Orden Compra N°' . $ordenCompra->numero . ' Pendiente.';
        return redirect()->route('ordenCompra')->with(['status' => $msg]);
    }

    public function pdf($numero) {

        $centroVenta = CentroVenta::getMainCentroVenta();
        $ordenCompra = OrdenCompra::with('proveedor','detalles')->where('numero',$numero)->first();
        //return view('documents.pdf.ordenCompraPDF',compact('ordenCompra','centroVenta'));
        $pdf = PDF::loadView('documents.pdf.ordenCompraPDF',compact('ordenCompra','centroVenta'));

        return $pdf->stream();
    }

    public function downloadPDF($numero) {

        $centroVenta = CentroVenta::getMainCentroVenta();
        $ordenCompra = OrdenCompra::with('proveedor','detalles')->where('numero',$numero)->first();
        //return view('documents.pdf.ordenCompraPDF',compact('ordenCompra','centroVenta'));
        $pdf = PDF::loadView('documents.pdf.ordenCompraPDF',compact('ordenCompra','centroVenta'));

        return $pdf->download('Orden Compra Nº'.$ordenCompra->numero.'.pdf');
    }
}
