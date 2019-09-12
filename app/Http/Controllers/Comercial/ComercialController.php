<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use PDF;
use Mail;
use App\Mail\NewNotaVenta;
use App\Models\Comercial\NotaVenta;

class ComercialController extends Controller
{
    public function main() {

        $menu = [
            ['name' => 'matenedor Nacional',
            'childs' => [['name' => 'clientes'], ['name' => 'vendedores'],['name' => 'lista de Precios']]],
            'Movimiento Nacional' => [['name' => 'clientes'], ['name' => 'vendedores'],['name' => 'lista de Precios']],
            'matenedor Internacional' => ['clientes','vendedores','lista de Precios'],
            'Movimiento Internacional' => ['clientes','vendedores','lista de Precios']
        ];

		return view('comercial.main')->with(['menu' => $menu]);
	}

}
