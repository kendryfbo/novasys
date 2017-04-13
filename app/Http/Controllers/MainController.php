<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:acceso');
    }

    public function index()
    {
    	return view('index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to('form-login');
    }
}
