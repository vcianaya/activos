<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// HELPERSS
use Hash;
use Session;
use Response;
use Illuminate\Support\Facades\Storage;

use App\User;
class UsuarioController extends Controller
{
	public function register_usuario()
	{
		return view('users.register_usuario');
	}
	public function save_user(Request $request)
	{
		// $this->validate($request, [
		// 	'ci' => 'required|unique:users',
		// 	'expedido' => 'required',
		// 	'nombre' => 'required',
		// 	'apellidoPaterno' => 'required',
		// 	'apellidoMaterno' => 'required',
		// 	'email' => 'required|unique:users',
		// 	'password' => 'required|min:5|confirmed',
		// 	'password_confirmation' => 'required|min:5',
		// 	'foto' => 'required|mimes:jpeg,jpg,png'
		// ]);

		// $user = new User();
		// $user->ci = $request->ci;
		// $user->expedido = strtoupper($request->expedido);
		// $user->nombre = strtoupper($request->nombre);
		// $user->ap_paterno = strtoupper($request->apellidoPaterno);
		// $user->ap_materno = strtoupper($request->apellidoMaterno);
		// $user->email = $request->email;
		// $user->password = Hash::make($request->password);
		// $user->foto = $request->file('foto')->store('foto_usuario');
		// $user->save();
		Session::flash('success','Usuario registrado');
		return back();
	}	
}
