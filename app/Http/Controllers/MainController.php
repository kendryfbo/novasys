<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct() {
        $this->middleware('auth:acceso')
    }
    public function index() {

    	return view('index');
    }

}
