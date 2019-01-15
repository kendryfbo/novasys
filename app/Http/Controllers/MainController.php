<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config\Acceso;
use App\Models\Config\PerfilAcceso;
use Storage;
class MainController extends Controller
{
    public function index() {

    	return view('index');
    }

}
