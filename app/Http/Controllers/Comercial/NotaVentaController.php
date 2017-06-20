<?php

namespace App\Http\Controllers\Comercial;

use App\Models\Comercial\NotaVenta;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ClienteNacional;
use App\Models\Comercial\FormaPagoNac;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\ListaPrecio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\Comercial\NotaVenta\NotaVentaRepositoryInterface;
class NotaVentaController extends Controller
{
    protected $notaVenta;

    public function __construct(NotaVentaRepositoryInterface $notaVenta) {

        $this->notaVenta = $notaVenta;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notasVentas = NotaVenta::all();
        NotaVenta::destroy(3);
        return view('comercial.notasVentas.index')->with(['notasVentas' => $notasVentas]);
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
        $formasPagos = FormaPagoNac::getAllActive();
        $vendedores = Vendedor::getAllActive();
        //$listasPrecios = ListaPrecio::where(); /* Implementado lista de precio por cliente

        return view('comercial.notasVentas.create')->with([
            'centrosVentas' => $centrosVentas,
            'clientes' => $clientes,
            'formasPagos' => $formasPagos,
            'vendedores' => $vendedores,
            //'listasPrecios' => $listasPrecios /* Implementado lista de precio por cliente
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
        // dd($request);

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

        $this->notaVenta->register($request);

        $msg = "NotaVenta: " . $request->numero . " ha sido Creado.";

        return redirect('comercial\notasVentas')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function show(NotaVenta $notaVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaVenta $notaVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaVenta $notaVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaVenta $notaVenta)
    {
        //
    }
    public function test(NotaVenta $notaVenta)
    {

    }
}
