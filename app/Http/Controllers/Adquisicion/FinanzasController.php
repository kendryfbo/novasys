<?php

namespace App\Http\Controllers\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Comercial\Proforma;
use App\Models\Comercial\NotaVenta;

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

        dd('authOC');
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

    // No autorizar Proforma
    public function unauthorizePF(Proforma $proforma) {

        $proforma->unauthorizeContab();

        $msg = 'Proforma Nº' . $proforma->numero . ' No Ha sido Autorizada.';

        return redirect()->route('autFinanzasPF')->with(['status' => $msg]);

    }

    // No autorizar Nota de Venta
    public function unauthorizeNV(NotaVenta $notaVenta) {

        $notaVenta->unauthorizeContab();

        $msg = 'Nota de Venta Nº' . $notaVenta->numero . ' No ha sido Autorizada.';

        return redirect()->route('autFinanzasNV')->with(['status' => $msg]);

    }
}
