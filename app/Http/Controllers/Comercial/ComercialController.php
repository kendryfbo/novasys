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

      $pdf = PDF::loadView('documents.pdf.model');
      return $pdf->stream();
      $notaVenta = NotaVenta::with('detalle','cliente.region:id,descripcion','centroVenta','formaPago:id,descripcion')->find(9);
      // dd($notaVenta);
      $pdf = PDF::loadView('documents.pdf.ordenDespacho',compact('notaVenta'));
      return $pdf->stream();
    }

    public function email() {

        $notaVenta = NotaVenta::find(10);
        $pdf = PDF::loadView('documents.pdf.ordenDespacho',compact('notaVenta'));
        // return $pdf->stream('invoice.pdf');
        $pdf->save('asdasdasdasdasd.pdf');
        return view('documents.pdf.ordenDespacho')->with(['notaVenta' => $notaVenta]);
        Mail::to('soporte@novafoods.cl')
        ->send(new NewNotaVenta($notaVenta));
        dd($notaVenta);

        return redirect()->back();
    }
}
