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
        $vendedores = Vendedor::getAllActive();

        return view('comercial.notasVentas.create')->with([
            'centrosVentas' => $centrosVentas,
            'clientes' => $clientes,
            'vendedores' => $vendedores
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
      $this->validate($request, [
          'centroVenta' => 'required',
          'fechaEmision' => 'required',
          'fechaVenc' => 'required',
          'cliente' => 'required',
          'formaPago' => 'required',
          'despacho' => 'required',
          'vendedor' => 'required',
          'items' => 'required'
      ]);

      $numero = $this->notaVenta->register($request);

      $msg = "Nota de Venta numero: " . $numero . " ha sido Creado.";

      return redirect('comercial\notasVentas')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $notaVenta = NotaVenta::where('numero',$numero)->first();

        if ($notaVenta) {

            $notaVenta->load('centroVenta:id,descripcion','cliente:id,descripcion','formaPago:id,descripcion','vendedor:id,nombre','detalle');

            return view('comercial.notasVentas.show')->with(['notaVenta' => $notaVenta]);
        } else {

            return redirect()->back();
        }
    }

    public function showForAut($numero)
    {
        $notaVenta = NotaVenta::where('numero',$numero)->first();

        if ($notaVenta) {

            $notaVenta->load('centroVenta:id,descripcion','cliente:id,descripcion','formaPago:id,descripcion','vendedor:id,nombre','detalle');

            return view('comercial.notasVentas.authorize')->with(['notaVenta' => $notaVenta]);
        } else {

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaVenta $notaVenta)
    {
        $notaVenta->load('detalle','cliente.sucursal',
                         'cliente.listaPrecio.detalle.producto.marca',
                         'cliente.listaPrecio.detalle.producto.formato',
                         'cliente.canal','cliente.formaPago');

        $vendedores = Vendedor::getAllActive();
        $centrosVentas = CentroVenta::getAllActive();

        return view('comercial.notasVentas.edit')->with([
            'notaVenta' => $notaVenta,
            'centrosVentas' => $centrosVentas,
            'vendedores' => $vendedores
        ]);
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
      // dd($request);
      // $this->validate($request, [
      //     'centroVenta' => 'required',
      //     'fechaEmision' => 'required',
      //     'fechaVenc' => 'required',
      //     'cliente' => 'required',
      //     'formaPago' => 'required',
      //     'despacho' => 'required',
      //     'vendedor' => 'required',
      //     'items' => 'required',
      // ]);

      $numero = $this->notaVenta->registerEdit($request,$notaVenta);

      $msg = "Nota de Venta numero: " . $numero . " ha sido Creado.";

      return redirect('comercial\notasVentas')->with(['status' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaVenta $notaVenta)
    {
        $notaVenta->delete();

        $msg = "Nota de Venta numero: " . $notaVenta->numero . " ha sido Eliminada.";

        return redirect('comercial\notasVentas')->with(['status' => $msg]);
    }

    public function authorization()
    {
        $notasVentas = NotaVenta::unauthorized();
        $notasVentas->load('cliente.formaPago');

        return view('comercial.notasVentas.authorization')->with(['notasVentas' => $notasVentas]);
    }

    public function authorizeNotaVenta(NotaVenta $notaVenta)
    {
        $notaVenta->authorize();

        $msg = "NotaVenta: " . $notaVenta->numero . " ha sido Autorizada.";

        return redirect('comercial/notasVentas/autorizacion')->with(['status' => $msg]);
    }

    public function unauthorizedNotaVenta(NotaVenta $notaVenta)
    {
        $notaVenta->unauthorize();

        $msg = "NotaVenta: " . $notaVenta->numero . " ha sido Desautorizada.";

        return redirect('comercial/notasVentas/autorizacion')->with(['status' => $msg]);
    }
}
