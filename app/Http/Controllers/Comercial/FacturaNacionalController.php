<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Config;
use Excel;
use Carbon\Carbon;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\Impuesto;
use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\FormaPagoNac;
use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\ClienteNacional;

use App\Repositories\Comercial\FacturaNacional\FacturaNacionalRepositoryInterface;

class FacturaNacionalController extends Controller
{
    protected $facturaNacional;

    public function __construct(FacturaNacionalRepositoryInterface $facturaNacional) {

        $this->facturaNacional = $facturaNacional;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = FacturaNacional::orderBy('created_at','desc')->get();

        return view('comercial.facturasNacionales.index')->with(['facturas' => $facturas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centrosVentas = CentroVenta::getAllActive();
        $clientes = ClienteNacional::getAllActive();
        $vendedores = Vendedor::getAllActive();
        $formasPagos = FormaPagoNac::getAllActive();

        return view('comercial.facturasNacionales.create')
                ->with(['centrosVentas' => $centrosVentas,
                        'clientes' => $clientes,
                        'vendedores' => $vendedores,
                        'formasPagos' => $formasPagos
                    ]);
    }

    public function createFromNV(Request $request) {

        $numNV = $request->numNV;

        $notaVenta = NotaVenta::with(
            'centroVenta:id,descripcion',
            'cliente.formaPago',
            'vendedor:id,nombre',
            'detalle')->where('numero',$numNV)->first();

        if ($notaVenta->factura) {

            $msg = 'Nota de Venta ya se encuentra asociada a Factura Nº'. $notaVenta->factura .'.';
            return redirect()->back()->with('status',$msg);

        } else if (!$notaVenta->isAuthorized()) {

            $msg = 'Nota de Venta no se encuentra Autorizada.';
            return redirect()->back()->with('status',$msg);
        }

        return view('comercial.facturasNacionales.createFromNV')->with(['notaVenta' => $notaVenta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'centroVenta' => 'required',
            'numero' => 'required',
            'fechaEmision' => 'required',
            //'fechaVenc' => 'required',
            'cliente' => 'required',
            'direccion' => 'required',
            'formaPago' => 'required',
            'despacho' => 'required',
            'vendedor' => 'required',
            'items' => 'required',
        ]);

        $this->facturaNacional->register($request);

        $msg = "Factura: " . $request->numero . " ha sido Creado.";

        return redirect('comercial\facturasNacionales')->with(['status' => $msg]);
    }

    public function storeFromNV(Request $request)
    {
        $this->validate($request, [
            'centroVenta' => 'required',
            'numero' => 'required',
            'fechaEmision' => 'required',
            //'fechaVenc' => 'required',
            'cliente' => 'required',
            'formaPago' => 'required',
            'diasFormaPago' => 'required',
            'despacho' => 'required',
            'vendedor' => 'required'
        ]);

        if (FacturaNacional::where('numero',$request->numero)->where('cv_id',$request->centroVenta)->first()) {

            $msg = 'Número de Factura ya existe para este Centro de Venta.';
            return redirect()->route('factNac')->with(['status' => $msg]);
        }

        $date = new Carbon($request->fechaEmision);
        $date->addDays($request->diasFormaPago);
        $date = $date->format('Y-m-d');
        $request->fechaVenc = $date;

        $this->facturaNacional->registerFromNV($request);

        $msg = "Factura: " . $request->numero . " ha sido Creado.";

        return redirect('comercial\facturasNacionales')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaNacional  $facturaNacional
     * @return \Illuminate\Http\Response
     */
    public function show($factura)
    {
        $factura = FacturaNacional::with('detalles')->where('id', $factura)->first();

        return view('comercial.facturasNacionales.show')->with(['factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comercial\FacturaNacional  $facturaNacional
     * @return \Illuminate\Http\Response
     */
    public function edit(FacturaNacional $facturaNacional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comercial\FacturaNacional  $facturaNacional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacturaNacional $facturaNacional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial\FacturaNacional  $facturaNacional
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacturaNacional $factura)
    {
        $this->facturaNacional->delete($factura);

        $msg = "Factura: " . $factura->numero . " ha sido Eliminada.";

        return redirect()->route('factNac')->with(['status' => $msg]);
    }

    public function download(FacturaNacional $factura) {

        //dd("Pendiente por implementar");
        $factura->load('clienteNac.comuna','detalles.producto.marca');

        foreach ($factura->detalles as &$detalle) {
            $valorIaba = Impuesto::getIaba()->valor;
            $valorIva = Impuesto::getIva()->valor;
            $impuesto = 0;
            $descuento = ($detalle->precio * $detalle->descuento) / 100;
            $precioUniTotal = $detalle->precio - $descuento;

            if ($detalle->producto->marca->iaba) {

                $impuesto = $valorIaba + $valorIva;
                $detalle->impuesto = 27;

            } else {

                $impuesto = 0;
            }

            $impuesto = ($precioUniTotal * $impuesto) / 100;
            $precioUniTotal = $precioUniTotal + $impuesto;
            $detalle->precio = $precioUniTotal;

            $detalle->impuesto = $detalle->impuesto ? $detalle->impuesto : $detalle->precio;
        }


        $excel = Excel::create('Factura_'.$factura->numero, function($excel) use ($factura) {
            $excel->sheet('New sheet', function($sheet) use ($factura) {
                $sheet->loadView('documents.excel.facturaNacional')
                        ->with('factura', $factura);
                    });
                });
        return $excel->download('xls');

    }

}
