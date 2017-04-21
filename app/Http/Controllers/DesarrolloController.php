<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesarrolloController extends Controller
{
    public function main(){

        $menus = ['productos','formatos','formulas','otros' => ['otro-1','otro-2','otro-3']];
		return view('desarrollo.main')->with('menus', $menus);
	}
}
