<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use Illuminate\Support\Facades\Auth;
// MODELS
use App\Sucursal;
use App\Area;
use App\Funcionario;
use App\Cargo;
class FuncionarioController extends Controller
{
	public function register_funcionario()
	{
		$sucursal = Sucursal::where('estado',1)->get();
		$cargo = Cargo::all();
		return view('funcionarios.register_funcionario',['sucursal'=>$sucursal, 'cargo'=>$cargo]);
	}
	public function get_areas_select2($id_sucursal)
	{
		$area = Area::select('id','nombre as text')->where('sucursal',$id_sucursal)->get();
		return response()->json(['data'=>$area]);
	}
	public function save_funcionario(Request $request)
	{
		$this->validate($request, [
			'ci' => 'required|unique:funcionario',
			'expedido' => 'required',
			'nombre' => 'required',
			'apellidoPaterno' => 'required',
			'apellidoMaterno' => 'required',
			'fechaNacimiento' => 'required',
			'genero' => 'required',
			'departamento' => 'required',
			'ciudad' => 'required',
			'celular' => 'required',
			'sucursal' => 'required',
			'area' => 'required',
			'cargo' => 'required',
			'foto' => 'required|mimes:jpeg,jpg,png'
		]);
		$funcionario = new Funcionario();
		$funcionario->ci = $request->ci;
		$funcionario->expedido = $request->expedido;
		$funcionario->nombre = $request->nombre;
		$funcionario->ap_paterno = $request->apellidoPaterno;
		$funcionario->ap_materno = $request->apellidoMaterno;
		$funcionario->fec_nac = $request->fechaNacimiento;
		$funcionario->genero = $request->genero;
		$funcionario->departamento = $request->departamento;
		$funcionario->ciudad = $request->ciudad;
		$funcionario->zona = $request->zona;
		$funcionario->calle = $request->calle;
		$funcionario->nro_puerta = $request->nro_puerta;
		$funcionario->telefono = $request->telefono;
		$funcionario->celular = $request->celular;
		$funcionario->email = $request->email;
		$funcionario->foto = $request->file('foto')->store('foto_funcionario');
		$funcionario->estado = 1;
		$funcionario->sucursal = $request->sucursal;
		$funcionario->area = $request->area;
		$funcionario->cargo = $request->cargo;
		$funcionario->usuario = Auth::user()->id;
		$funcionario->save();
		Session::flash('success','Funcionario Creado');
		return back();
	}
	public function editar_funcionario($id_funcionario)
	{
		$funcionario = Funcionario::find($id_funcionario);
		$sucursal = Sucursal::where('estado',1)->get();
		$cargo = Cargo::all();
		return view('funcionarios.editar_funcionario',['funcionario'=>$funcionario, 'sucursal'=>$sucursal, 'cargo'=>$cargo]);
	}
	public function list_funcionarios()
	{
		$funcionarios = Funcionario::join('sucursal', 'sucursal.id', '=', 'funcionario.sucursal')
		->join('cargo', 'cargo.id','=','funcionario.cargo')
		->join('area', 'area.id','=','funcionario.area')
		->select('funcionario.id','funcionario.estado', 'funcionario.nombre','funcionario.ap_paterno','funcionario.ap_materno','funcionario.fec_nac','funcionario.departamento','funcionario.ciudad','funcionario.celular','area.nombre as area','cargo.cargo','sucursal.nombre as sucursal','funcionario.foto')
		->get();
		return view('funcionarios.listar_funcionarios',['funcionarios'=>$funcionarios]);
	}
}