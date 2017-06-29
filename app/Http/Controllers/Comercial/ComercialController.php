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

    public function excel() {

        Excel::create('Factura', function($excel) {

            $excel->sheet('FirstSheet', function($sheet){

                $sheet->loadView('documents.excel.facturaNacional');
            });
            
        })->export('xls');

    }

    public function pdf() {
        $notaVenta = NotaVenta::with('detalle','cliente.region:id,descripcion','centroVenta','formaPago:id,descripcion')->find(9);
        // dd($notaVenta);
        $pdf = PDF::loadView('documents.pdf.ordenDespacho',compact('notaVenta'));
        return $pdf->stream();
    }

    public function email() {

        NotaVenta::create([
            'numero' => 1
        ]);

        return redirect()->back();
    }
}
