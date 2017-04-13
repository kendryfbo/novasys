<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class AccessoController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:acceso');
	}

    public function login() {

		//return view('welcome');
		if (Auth::guard('acceso')->attempt(['user' => 'kendryfbo','password' => '1234']))
		{

			return redirect()->intended(route('index'));

		}

		return redirect()->to('login-form');
	}

	public function formLogin()
	{

		return view('login');

	}
}
