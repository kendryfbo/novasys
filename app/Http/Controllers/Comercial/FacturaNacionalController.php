<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\FacturaNacional;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FormaPagoNac;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\Vendedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $facturas = FacturaNacional::all();
        return view('comercial.facturasNacionales.index');
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
            'cliente:id,descripcion',
            'vendedor:id,nombre',
            'detalle')->where('numero',$numNV)->first();

        if ($notaVenta) {

            return view('comercial.facturasNacionales.createFromNV')->with(['notaVenta' => $notaVenta]);
        } else {

            return redirect()->back();
        }
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
            'fechaVenc' => 'required',
            'cliente' => 'required',
            'formaPago' => 'required',
            'despacho' => 'required',
            'vendedor' => 'required',
            'items' => 'required',
            // 'items.*.id' => 'required',
            // 'items.*.descripcion' => 'required|string'
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
            'fechaVenc' => 'required',
            'cliente' => 'required',
            'formaPago' => 'required',
            'despacho' => 'required',
            'vendedor' => 'required',
            'items' => 'required',
            // 'items.*.id' => 'required',
            // 'items.*.descripcion' => 'required|string'
        ]);

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
    public function show(FacturaNacional $facturaNacional)
    {
        //
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
    public function destroy(FacturaNacional $facturaNacional)
    {
        //
    }

}
