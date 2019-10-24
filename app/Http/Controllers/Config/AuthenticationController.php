<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Models\Config\Usuario;
use App\Models\Comercial\Vendedor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

	public function __construct() {

	//$this->middleware('auth');
	}

	public function login(Request $request) {

		$user = $request->user;
		$password = $request->password;

		if (Auth::attempt(['user' => $user, 'password' => $password, 'activo' => 1])) {

			$vendedor = Vendedor::where('user_id','=',Auth::user()->id)->first();
			$clientIP = \Request::ip();

			if (Auth::user()->extAccess == 0 && !preg_match('/192.168.\b/', $clientIP)) {

				dd("Sin Permiso para Acceder Externamente...");

			}	else
			{
					if(isset($vendedor)) {
				 		return redirect()->route('notaVentaByVendedor');
		 			} else {
						return redirect()->intended('/');
					}
			}

	 	return redirect()->intended('/');

		} else {

			$msg = 'Combinación de Usuario y Contraseña Inválida';

			return redirect()->back()->with(['status' => $msg]);
		}

	}

	public function signIn()
	{
		return  view('auth.signin');
	}

	public function logout(Request $request)
	{
		Auth::logout();

		return redirect('ingresar');
	}
}
