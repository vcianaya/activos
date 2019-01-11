<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//MODELS
use App\Sucursal;
use App\Funcionario;
use App\Almacen;
use App\Equipo;
use App\EquipoAsignado;
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
			$data[]=[
				'id'=> ' ',
				'text' => 'Elija una opcion'
			];
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

	public function get_equipos_table($id_almacen)
	{
		$equipos_asignados = EquipoAsignado::select('equipo')->where('estado',1)->get();
		$equipos = Equipo::join('categoria','equipo.categoria','=','categoria.id')
		->select('equipo.id as id_equipo','equipo.descripcion','equipo.nro_serie','equipo.marca','equipo.modelo','equipo.modelo_procesador','equipo.codigo_siaf','equipo.estado_equipo','equipo.fecha_ingreso','equipo.observacion','categoria.nombre as categoria','categoria.vida_util')
		->where('equipo.almacen',$id_almacen)
		->whereNotIn('equipo.id', $equipos_asignados)
		->get();
		return view('activos.equipos_table',['equipos'=>$equipos]);
	}

	public function save_activos(Request $request)
	{
		$this->validate($request, [
			'funcionario' => 'required',
			'detalle_asignacion' => 'required',
			'datepicker' => 'required',
		]);
		$equipos = explode(",", $request->equipos[0]);
		foreach ($equipos as $id_equipo) {
			$equipo_asignado = new EquipoAsignado();
			$equipo_asignado->equipo = $id_equipo;
			$equipo_asignado->funcionario = $request->funcionario;
			$equipo_asignado->usuario = Auth::user()->id;
			$equipo_asignado->detalle_asignacion = $request->detalle_asignacion;
			$equipo_asignado->fec_asignacion = $request->datepicker;
			$equipo_asignado->estado = 1;
			$equipo_asignado->save();
		}
		return response()->json(['type' => 'success','icon'=>'fa fa-save','message'=>'Activos Asignados']);
	}

	public function devolver_activo()
	{
		$funcionarios = Funcionario::join('sucursal', 'sucursal.id', '=', 'funcionario.sucursal')
		->join('cargo', 'cargo.id','=','funcionario.cargo')
		->join('area', 'area.id','=','funcionario.area')
		->select('funcionario.id','funcionario.estado', 'funcionario.nombre','funcionario.ap_paterno','funcionario.ap_materno','funcionario.fec_nac','funcionario.departamento','funcionario.ciudad','funcionario.celular','area.nombre as area','cargo.cargo','sucursal.nombre as sucursal','funcionario.foto')
		->get();
		return view('activos.devolver_activo',['funcionarios'=>$funcionarios]);
	}

	public function get_activos_asignados($id_funcionario)
	{
		$equipos = Equipo::join('categoria','equipo.categoria','=','categoria.id')
		->leftjoin('equipo_asignado','equipo.id','=','equipo_asignado.equipo')
		->leftjoin('funcionario','funcionario.id','=','equipo_asignado.funcionario')
		->join('almacen','almacen.id','=','equipo.almacen')
		->join('sucursal','almacen.sucursal','=','sucursal.id')
		->select('equipo_asignado.id as id_asignacion','equipo.id as id_equipo','equipo.descripcion','equipo.nro_serie','equipo.marca','equipo.modelo','equipo.modelo_procesador','equipo.codigo_siaf','equipo.estado_equipo','equipo.fecha_ingreso','equipo.observacion','categoria.nombre as categoria','categoria.vida_util','funcionario.nombre as nombre_funcionario','funcionario.ap_paterno','funcionario.ap_materno','almacen.nombre as almacen','sucursal.nombre as sucursal','equipo_asignado.fec_asignacion')
		->where('funcionario.id',$id_funcionario)
		->where('equipo_asignado.estado',1)
		->get();
		if (count($equipos)>0) {
			foreach ($equipos as $item) {
				$data[] = [
					'DT_RowId' => $item->id_asignacion,
					'codigo_siaf' => $item->codigo_siaf,
					'marca' => $item->marca,
					'modelo_procesador' => $item->modelo_procesador,
					'fec_asignacion' => $item->fec_asignacion,
					'descripcion' => $item->descripcion,				
					'accion' => 
					'<div class="btn-group">
					<a data-balloon="Devolver Activo" data-balloon-pos="up" type="button" class="btn btn-danger devolver_activo">
					<i class="fa fa-eject"></i>
					</a>
					</div>'
				];
			}
			return response()->json(['data' => $data]);
		}else{
			return response()->json(['data' => false]);
		}
		
	}

	public function get_activo_asignado($id_asignacion)
	{
		$equipo = EquipoAsignado::join('equipo', 'equipo_asignado.equipo', '=', 'equipo.id')
		->select('equipo.*','equipo_asignado.id as id_asignacion')
		->where('equipo_asignado.estado',1)
		->where('equipo_asignado.id',$id_asignacion)
		->first();
		return view('activos.formulario_devolucion',['equipo'=>$equipo]);
	}
	public function save_devolver_activos(Request $request)
	{
		// estado 1 asignado | 0 devuelto
		$data = $request->input('asignados');
		foreach ($data as $item) {
			$equipoAsignado = EquipoAsignado::find($item['id']);
			$equipoAsignado->estado = 0;
			$equipoAsignado->detalle_devolucion = $item['observacion'];
			$equipoAsignado->save();
		}
		return response()->json(['type' => 'success','icon'=>'fa fa-check-circle','message'=>'Activos Devueltos']);
	}
}

