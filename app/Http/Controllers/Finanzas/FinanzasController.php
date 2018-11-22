<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ClienteIntl;
use App\Models\Comercial\FacturaIntl;
use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;
use App\Models\Adquisicion\OrdenCompra;
use App\Models\Finanzas\AbonosIntl;


class FinanzasController extends Controller
{

    public function index() {

        return view('finanzas.main');
    }
    // Lista de Proformas por autorizar
    public function authPF() {

        $proformas = Proforma::whereNull('aut_contab')->where('aut_comer',1)->get();

        return view('finanzas.autorizacion.authorizationPF')->with(['proformas' => $proformas]);
    }

    // Lista de Notas de Venta por autorizar
    public function authNV() {

        $notasVentas = notaVenta::whereNull('aut_contab')->where('aut_comer',1)->get();

        return view('finanzas.autorizacion.authorizationNV')->with(['notasVentas' => $notasVentas]);
    }

    // Lista de Ordenes de Compra por autorizar
    public function authOC() {

        $ordenesCompra = OrdenCompra::with('proveedor.formaPago','area','status','tipo')->orderBy('numero','desc')->whereNull('aut_contab')->get();

        return view('finanzas.autorizacion.authorizationOC')->with(['ordenesCompra' => $ordenesCompra]);
    }

    // Ver Proforma para autorizar
    public function showAuthFinanzasPF(Proforma $proforma) {

        if ($proforma->aut_comer == 1 && $proforma->aut_contab == null) {

            return view('finanzas.autorizacion.authorizePF')->with(['proforma' => $proforma]);
        }
        return redirect()->back();
    }

    // Ver Nota de Venta para autorizar
    public function showAuthFinanzasNV(NotaVenta $notaVenta) {

        if ($notaVenta->aut_comer == 1 && $notaVenta->aut_contab == null) {

            return view('finanzas.autorizacion.authorizeNV')->with(['notaVenta' => $notaVenta]);
        }
        return redirect()->back();
    }
    // Ver Orden de Compra para autorizar
    public function showAuthFinanzasOC(OrdenCompra $ordenCompra) {

        if ($ordenCompra->aut_contab == null) {

            return view('finanzas.autorizacion.authorizeOC')->with(['ordenCompra' => $ordenCompra]);
        }
        return redirect()->back();
    }

    // Autorizar Proforma
    public function authorizePF(Proforma $proforma) {

        $proforma->authorizeContab();
        $msg = 'Proforma Nº' . $proforma->numero . ' Ha sido Autorizada.';
        return redirect()->route('autFinanzasPF')->with(['status' => $msg]);

    }

    // Autorizar Nota de Venta
    public function authorizeNV(NotaVenta $notaVenta) {

        $notaVenta->authorizeContab();
        $msg = 'Nota de Venta Nº' . $notaVenta->numero . ' Ha sido Autorizada.';
        return redirect()->route('autFinanzasNV')->with(['status' => $msg]);
    }

    // Autorizar Orden Compra
    public function authorizeOC(OrdenCompra $ordenCompra) {

        $ordenCompra->authorizeContab();
        $msg = 'Orden Compra Nº' . $ordenCompra->numero . ' Ha sido Autorizada.';
        return redirect()->route('autFinanzasOC')->with(['status' => $msg]);
    }

    // No autorizar Proforma
    public function unauthorizePF(Proforma $proforma) {

        $proforma->unauthorizeContab();
        $msg = 'Proforma Nº' . $proforma->numero . ' No Ha sido Autorizada.';
        return redirect()->route('autFinanzasPF')->with(['status' => $msg]);
    }

    // No autorizar Nota de Venta
    public function unauthorizeNV(NotaVenta $notaVenta) {

        $notaVen -> unauthorizeContab();
        $msg = 'Nota de Venta Nº' . $notaVenta->numero . ' No ha sido Autorizada.';
        return redirect()->route('autFinanzasNV')->with(['status' => $msg]);
    }
    // No autorizar Orden Compra
    public function unauthorizeOC(OrdenCompra $ordenCompra) {

        $ordenCompra->unauthorizeContab();

        $msg = 'Orden Compra Nº' . $ordenCompra->numero . ' No ha sido Autorizada.';
        return redirect()->route('autFinanzasOC')->with(['status' => $msg]);
    }



    /**
     * Crea Abono de Cliente Intl
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function creaAbonoFactIntl() {


        $fecha_hoy = Carbon::now();
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagos_intl.createAbono')->with(['clientes' => $clientes, 'fecha_hoy' => $fecha_hoy]);
    }


    /**
     * Guarda Abono de Cliente Intl
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        public function guardaAbonoFactIntl(Request $request) {

            $abonoIntl = AbonosIntl::create([
                "cliente_id" => $request->input('cliente'),
                "usuario_id" => Auth::user()->id,
                "monto" => $request->input('monto'),
                "orden_despacho" => $request->input('orden_despacho'),
                "fecha_abono" => $request->input('fecha_abono'),
                ]);

                $msg = '$ '.$abonoIntl->monto.' fueron abonados a Cliente Nº '.$abonoIntl->clienteIntl->descripcion.' exitosamente.';
                return redirect()->route('crearAbonoFactInternacional')->with(['status' => $msg]);

    }


    /**
     * Pago de Facturas Intl
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function creaPagoFactIntl() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagos_intl.create')->with(['clientes' => $clientes]);


    }



    /**
     *  Historial de Pago de Facturas Internacionales por Clientes
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function historialPago() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagos_intl.historial')->with(['clientes' => $clientes]);


    }


    /**
     *  Lista de Facturas por Cobrar
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

    public function facturasPorCobrar(Request $request) {
        $busqueda = $request;
        $facturas = [];

        if ($request->all()) {
            $queryDates = [];
            $queryClientes = [];

            if ($request->desde) {
                $desde = ['fecha_emision', '>=', $request->desde];
                array_push($queryDates,$desde);
            };

            if ($request->hasta) {
                $hasta = ['fecha_emision', '<=', $request->hasta];
                array_push($queryDates,$hasta);
            };

            if ($request->cliente) {
                $cliente = ['id', '=', $request->cliente];
                array_push($queryClientes,$cliente);
            };

            $clientes = ClienteIntl::where($queryClientes)->pluck('id');
            $facturas = FacturaIntl::whereIn('cliente_id',$clientes)->where($queryDates)->get();
        }

        $clientes = ClienteIntl::getAllActive();

        return view('finanzas.pagos_intl.facturasPorCobrar')
                ->with([
                    'busqueda' => $busqueda,
                    'facturas' => $facturas,
                    'clientes' => $clientes
                ]);
    }


    /**
     *  Anular Factura Internacional por Cliente
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Controllers\Api\ApiFacturaIntlController;
     */

        public function anularFactIntl() {
        $clientes = ClienteIntl::getAllActive();
        return view('finanzas.pagos_intl.anularFactIntl')->with(['clientes' => $clientes]);


    }


}
