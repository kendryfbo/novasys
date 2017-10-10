<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class DesarrolloController extends Controller
{
    public function main(){

        $menus = ['marcas','productos','formatos','formulas','otros' => ['otro-1','otro-2','otro-3']];
		return view('desarrollo.main')->with('menus', $menus);
	}

	public function pdf() {

		$pdf = PDF::loadView('documents.pdf.model');

        return $pdf->stream();
	}

  public function htmlPdf() {

    return view('documents.pdf.model');
  }
}
