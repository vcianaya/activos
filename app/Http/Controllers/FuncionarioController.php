<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// MODELS
use App\Sucursal;
use App\Area;
class FuncionarioController extends Controller
{
	public function register_funcionario()
	{
    $sucursal = Sucursal::where('estado',1)->get();
		return view('funcionarios.register_funcionario',['sucursal'=>$sucursal]);
	}

  public function get_areas_select2($id_sucursal)
  {
    $area = Area::select('id','nombre as text')->where('sucursal',$id_sucursal)->get();
    return response()->json(['data'=>$area]);
  }
}
