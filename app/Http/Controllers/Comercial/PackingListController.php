<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackingListController extends Controller
{
  
  public function create() {

    return view('comercial.packingList.create');
  }

  public function generatePDF(Request $request) {

    return dd('pdf');
  }
}
