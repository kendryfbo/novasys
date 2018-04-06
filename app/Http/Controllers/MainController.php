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

    public function welcome(Request $request) {

        Storage::disk('local')->put('public/file.txt', 'Contents');
        dd (asset('storage/file.txt'));

        dd($request->route());
    }

    public function accesos() {

        Acceso::arrayOfAccess();
    }

}
