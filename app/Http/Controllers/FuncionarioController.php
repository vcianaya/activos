<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
	public function register_funcionario()
	{
		return view('funcionarios.register_funcionario');
	}
}
