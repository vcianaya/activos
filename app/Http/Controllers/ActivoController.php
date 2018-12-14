<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//MODELS
use App\Sucursal;
use App\Funcionario;
use App\Almacen;
class ActivoController extends Controller
{
	public function asignar_equipo()
	{
		$sucursal = Sucursal::all();
		return view('activos.asignar',['sucursal'=>$sucursal]);
	}

	public function get_funcionarios($id_sucursal)
	{
		$funcionario = Funcionario::where('sucursal',$id_sucursal)->get();
		if ($funcionario->count()>0) {
			foreach ($funcionario as $item) {
				$data[] = [
					'id' => $item->id,
					'text' => $item->nombre.' '.$item->ap_paterno.' '.$item->ap_materno,
				];
			}
			return response()->json(['data' => $data]);
		}else{
			return response()->json(['data' => null]);
		}
	}
	public function get_almacen($id_sucursal)
	{
		$almacen = Almacen::where('sucursal',$id_sucursal)->get();
		if ($almacen->count()>0) {
			foreach ($almacen as $item) {
				$data[] = [
					'id' => $item->id,
					'text' => $item->nombre,
				];
			}
			return response()->json(['data' => $data]);
		}else{
			return response()->json(['data' => null]);
		}
	}
}
