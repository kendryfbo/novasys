<?php

namespace App\Http\Controllers\Finanzas;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finanzas\ChequeCartera;


class ChequesCarteraController extends Controller
{

    /**
     * Index de Abonos de Clientes Intl
     *
     * @param  \Illuminate\Http\Request  $request
     */

        public function index() {

        $chequesCartera = ChequeCartera::getAllActive();

        return view('finanzas.chequesCartera.index')->with(['chequesCartera' => $chequesCartera]);
    }


    // Autorizar Cheque en Cartera
    public function authorizeChequeCartera(ChequeCartera $chequeCartera) {

        $chequeCartera->authorizeCC();
        $msg = 'Cheque en Cartera Nº' . $chequeCartera->id . ' Ha sido Autorizada.';
        return redirect()->route('chequesCartera')->with(['status' => $msg]);

    }



}
