<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipo;
use App\Categoria;
use App\EquipoAsignado;
use App\Sucursal;
use App\Almacen;
class PrincipalController extends Controller
{
	public function principal()
	{
		$categoria = Categoria::select('id','nombre')->get();
		$data_equipos = [];
		foreach ($categoria as $item) {
			$equipos = $this->get_equipos($item->id);
			$data_equipos[] = [
					'categoria'=>$item->nombre, 
					'total'=> $equipos['total'],
					'asignados'=>['nombre'=>'Asignado','total'=>$equipos['asignados']],
					'disponibles'=>['nombre'=>'Disponible', 'total'=>$equipos['disponibles']]
			];
		}

		$sucursal = Sucursal::all();
		$data_sucursal = [];
		foreach ($sucursal as $item) {
			$data_sucursal[] = [
				'name'=>$item->nombre,
				'y' => Almacen::join('equipo','equipo.almacen','=','almacen.id')->where('almacen.sucursal',$item->id)->count()
			];
		}
		// return json_encode($data_equipos);
		return view('principal',['equipos'=> json_encode($data_equipos),'sucursal'=>json_encode($data_sucursal)]);
	}

	public function get_equipos($id_categoria)
	{
		$equipos = Equipo::where('categoria',$id_categoria)->get();
		$asignados = EquipoAsignado::join('equipo', 'equipo_asignado.equipo', '=', 'equipo.id')
		->where('equipo_asignado.estado',1)
		->where('equipo.categoria',$id_categoria)
		->select('*')
		->get();


		return ['total' => count($equipos),'asignados'=>count($asignados),'disponibles'=>count($equipos)-count($asignados)];
		
	}
}
