<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
	public function register_usuario(Request $request)
	{
		return view('users.register_usuario');
	}
}
