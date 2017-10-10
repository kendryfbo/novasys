<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Models\Config\Usuario;
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

			return redirect()->intended('/');

		} else {

			$msg = 'Combinacion de Usuario y Contraseña Invalida';

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
