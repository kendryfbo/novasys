<?php

namespace App\Http\Controllers\Comercial;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Comercial\Vendedor;
use App\Models\Comercial\NotaVenta;
use App\Http\Controllers\Controller;
use App\Models\Comercial\CentroVenta;
use App\Models\Comercial\ListaPrecio;
use App\Models\Comercial\FormaPagoNac;
use App\Events\AuthorizedNotaVentaEvent;
use App\Models\Comercial\ClienteNacional;

use App\Repositories\Comercial\NotaVenta\NotaVentaRepositoryInterface;

class NotaVentaByVendedorController extends Controller
{
    protected $notaVenta;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userID = \Auth::user()->id;
        $vendedor = Vendedor::where('user_id',$userID)->first();
        $vendedorID = $vendedor->id;
        $notasVentas = NotaVenta::with('cliente')->where('vendedor_id',$vendedorID)->orderBy('numero','desc')->take(50)->get();

        return view('comercial.notasVentasByVendedor.index')->with(['notasVentas' => $notasVentas]);
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
        $userID = \Auth::user()->id;
        $vendedor = Vendedor::where('user_id',$userID)->first();
        $vendedorID = $vendedor->id;
        $fechaToday = Carbon::now();


        return view('comercial.notasVentasByVendedor.create')->with([
            'centrosVentas' => $centrosVentas,
            'clientes' => $clientes,
            'vendedorID' => $vendedorID,
            'fechaToday' => $fechaToday
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

      dd($request);

      $this->validate($request, [
          //'numero' => 'required',
          'centroVenta' => 'required',
          'fechaEmision' => 'required',
          'fechaDespacho' => 'required',
          'cliente' => 'required',
          'formaPago' => 'required',
          'despacho' => 'required',
          'direccion' => 'required',
          'vendedor' => 'required',
          'items' => 'required'
      ]);

      $numero = $this->notaVenta->register($request);

      $msg = "Nota de Venta N° " . $numero . " ha sido Creado.";

      return redirect()->route('notaVentaByVendedor')->with(['status' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotaVenta  $notaVenta
     * @return \Illuminate\Http\Response
     */
    public function show($numero)
    {
        $userID = \Auth::user()->id;
        $vendedor = Vendedor::where('user_id',$userID)->first();
        $vendedorID = $vendedor->id;
        $notaVenta = NotaVenta::where('numero',$numero)->where('vendedor_id',$vendedorID)->first();

        if ($notaVenta) {

            $notaVenta->load('centroVenta:id,descripcion','cliente:id,descripcion','formaPago:id,descripcion','vendedor:id,nombre','detalle');

            return view('comercial.notasVentasByVendedor.show')->with(['notaVenta' => $notaVenta]);
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
    public function edit($numero)
    {
        $notaVenta = NotaVenta::with('detalle.producto.marca','cliente.sucursal',
                         'cliente.listaPrecio.detalle.producto.marca',
                         'cliente.listaPrecio.detalle.producto.formato',
                         'cliente.canal','cliente.formaPago')->where('numero',$numero)->first();

       $userID = \Auth::user()->id;
       $vendedor = Vendedor::where('user_id',$userID)->first();
       $vendedorID = $vendedor->id;

        return view('comercial.notasVentasByVendedor.edit')->with([
            'notaVenta' => $notaVenta,
            'vendedorID' => $vendedorID
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
      $this->validate($request, [
         'centroVenta' => 'required',
         'fechaEmision' => 'required',
         'fechaDespacho' => 'required',
         'cliente' => 'required',
         'formaPago' => 'required',
         'despacho' => 'required',
         'vendedor' => 'required',
         'items' => 'required',
       ]);

      $numero = $this->notaVenta->registerEdit($request,$notaVenta);

      $msg = "Nota de Venta numero: " . $numero . " ha sido Editada.";

      return redirect()->route('notaVentaByVendedor')->with(['status' => $msg]);
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

        return redirect()->route('notaVenta')->with(['status' => $msg]);
    }

}
