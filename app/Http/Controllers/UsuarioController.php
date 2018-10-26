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
		$user = User::select('*')->get();
		return view('users.register_usuario',['users'=>$user]);
	}
	public function save_user(Request $request)
	{
		$this->validate($request, [
			'ci' => 'required|unique:users',
			'expedido' => 'required',
			'nombre' => 'required',
			'apellidoPaterno' => 'required',
			'apellidoMaterno' => 'required',
			'email' => 'required|unique:users',
			'password' => 'required|min:5|confirmed',
			'password_confirmation' => 'required|min:5',
			'foto' => 'required|mimes:jpeg,jpg,png'
		]);

		$user = new User();
		$user->ci = $request->ci;
		$user->expedido = strtoupper($request->expedido);
		$user->nombre = strtoupper($request->nombre);
		$user->ap_paterno = strtoupper($request->apellidoPaterno);
		$user->ap_materno = strtoupper($request->apellidoMaterno);
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->foto = $request->file('foto')->store('foto_usuario');
		$user->save();
		Session::flash('success','Usuario registrado');
		return back();
	}
	public function editar_usuario($id)
	{
		$users = User::select('*')->get();
		$user = User::find($id);
		return view('users.editar_usuario',['users'=>$users,'user'=>$user]);
	}

	public function update_user(Request $request)
	{
		$this->validate($request, [
			'ci' => 'required',
			'expedido' => 'required',
			'nombre' => 'required',
			'apellidoPaterno' => 'required',
			'apellidoMaterno' => 'required',
			'email' => 'required',			
		]);
		if ($request->id != ''){
			$user = User::find($request->id);
		}
		if ($request->ci != ''){
			$user->ci = $request->ci;
		}
		if ($request->expedido != ''){
			$user->expedido = strtoupper($request->expedido);
		}
		if ($request->nombre != ''){
			$user->nombre = strtoupper($request->nombre);
		}
		if ($request->apellidoPaterno != ''){
			$user->ap_paterno = strtoupper($request->apellidoPaterno);
		}
		if ($request->apellidoMaterno != ''){
			$user->ap_materno = strtoupper($request->apellidoMaterno);
		}
		if ($request->email != ''){
			$user->email = $request->email;
		}
		if (strlen($request->password)>4) {
			$user->password = Hash::make($request->password);
		}
		if (!is_null($request->file('foto'))) {
			Storage::delete($user->foto);
			$user->foto = $request->file('foto')->store('foto_usuario');
		}
		$user->save();
		Session::flash('success','Datos Actualizados');

		return back();
	}

	public function delete_user($id)
	{
		$user = User::find($id);
		$user->estado = 0;
		$user->save();
		Session::flash('error','Usuario eliminado');
		return back();
	}

	public function restore_user($id)
	{
		$user = User::find($id);
		$user->estado = 1;
		$user->save();
		Session::flash('success','Usuario restaurado');
		return back();
	}
}
