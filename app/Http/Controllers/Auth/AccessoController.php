<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Route;

class AccessoController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:acceso');
	}

    public function login() {

		if (Auth::guard('acceso')->attempt(['user' => 'kendryfbo','password' => '1234']))
		{
			//dd(Auth::user()->role->permisos);

			session(['accesos' => Auth::user()->role->permisos->pluck('acceso', 'descripcion')]);
			//dd(session()->get('accesos')->toArray());
			return redirect()->intended(route('index'));

		}

		return redirect()->to('login-form');
	}

	public function formLogin()
	{

		return view('login');

	}
}
