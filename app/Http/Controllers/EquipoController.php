<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Response;
use Illuminate\Support\Facades\Storage;
//MODELS
use App\Sucursal;
use App\Categoria;
use App\Almacen;
use App\Equipo;
class EquipoController extends Controller
{
	public function registrar_categoria()
	{
		return view('equipos.crear_categoria');
	}

	public function save_categoria(Request $request)
	{
		$this->validate($request, [
			'codigo' => 'required|unique:categoria,codigo',
			'categoria' => 'required',
			'tiempo_vida_util' => 'required|numeric',
			'foto' => 'required|mimes:jpeg,jpg,png'
		]);
		$categoria = new Categoria();
		$categoria->codigo = strtoupper($request->codigo);
		$categoria->nombre = strtoupper($request->categoria);
		$categoria->vida_util = strtoupper($request->tiempo_vida_util);
		$categoria->foto = $request->file('foto')->store('foto_categoria');
		$categoria->save();
		return response()->json(['type' => 'success','icon'=>'fa fa-save','message'=>'Categoria creada']);
	}

	public function get_categorias(Request $request)
	{
		$categoria = Categoria::leftjoin('equipo', 'categoria.id', '=', 'equipo.categoria')
		->select('categoria.id','categoria.codigo','categoria.nombre','categoria.vida_util','categoria.foto',DB::raw('count(equipo.id) as total'))
		->groupBy('categoria.id')
		->get();
		$data = [];
		foreach ($categoria as $item) {
			$data[] = [
				'DT_RowId' => $item->id,
				'codigo' => $item->codigo,
				'nombre' => $item->nombre,
				'vida_util' => $item->vida_util." Meses",
				'foto' => '<img src="'.URL::to("/storage/".$item->foto).'" width="100rem"   height="100rem">',
				'total_equipos' => $item->total,
				'accion' => 
				'<div class="btn-group">
						<a href="#" data-balloon="Editar Area" data-balloon-pos="up" type="button" class="btn btn-warning edit-categoria">
							<i class="fa fa-edit"></i>
						</a>
				</div>'
			];
		}
		return response()->json(['data' => $data]);
	}

	public function editar_categoria($id_categoria)
	{
		$categoria = Categoria::find($id_categoria);
		return Response::json(view('equipos.editar_categoria', ['categoria'=>$categoria])->render());
	}

	public function update_categoria(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
			'categoria' => 'required',
			'tiempo_vida_util' => 'required|numeric',
		]);
		if ($request->id != ''){
			$categoria = Categoria::find($request->id);
		}
		if ($request->categoria != ''){
			$categoria->nombre = strtoupper($request->categoria);
		}

		if ($request->tiempo_vida_util != ''){
			$categoria->vida_util = strtoupper($request->tiempo_vida_util);
		}
		
		if (!is_null($request->file('foto'))) {
			Storage::delete($categoria->foto);
			$categoria->foto = $request->file('foto')->store('foto_categoria');
		}
		$categoria->save();
		return response()->json(['type' => 'success','icon'=>'fa fa-save','message'=>'Categoria actualizada']);
	}

	public function create_equipo()
	{
		$categoria = Categoria::all();
		$sucursal = Sucursal::where('estado',1)->get();
		return view('equipos.crear_equipo',['sucursal'=>$sucursal,'categoria'=>$categoria]);
	}

	public function get_almacenes_select2($id_sucursal)
	{
		$almacen = Almacen::select('id','nombre as text')->where('sucursal',$id_sucursal)->get();
		return response()->json(['data'=>$almacen]);
	}

	public function save_equipo(Request $request)
	{
		$equipo = new Equipo();
		$equipo->categoria = $request->categoria;
		$equipo->descripcion = $request->descripcion;
		$equipo->nro_serie = $request->serie;
		$equipo->marca = strtoupper($request->marca);
		$equipo->modelo = strtoupper($request->modelo);
		$equipo->modelo_procesador = $request->procesador;
		$equipo->fecha_ingreso = $request->datepicker;
		$equipo->almacen = $request->almacen;
		$equipo->estado_equipo = 1;
		$equipo->observacion = $request->observacion;
		$equipo->save();

		$equipo->codigo_siaf = strtoupper($request->marca).'-'.$equipo->id;
		$equipo->save();
		return response()->json(['type' => 'success','icon'=>'fa fa-save','message'=>'Equipo creado']);
	}
	public function get_codigo_categoria($id_categoria)
	{
		$categoria = Categoria::find($id_categoria);
		return $categoria;
	}

	public function get_equipos()
	{
		$equipos = Equipo::join('almacen', 'almacen.id', '=', 'equipo.almacen')
		->join('sucursal','almacen.sucursal','=','sucursal.id')
		->select('equipo.codigo_siaf','equipo.marca','equipo.modelo','equipo.modelo_procesador','equipo.fecha_ingreso','equipo.descripcion','sucursal.nombre as sucursal','almacen.nombre as almacen')
		->get();

		foreach ($equipos as $item) {
			$data[] = [
				'DT_RowId' => $item->id,
				'codigo_siaf' => $item->codigo_siaf,
				'marca' => $item->marca,
				'modelo' => $item->modelo,
				'modelo_procesador' => $item->modelo_procesador,
				'fecha_ingreso' => $item->fecha_ingreso,
				'descripcion' => $item->descripcion,
				'sucursal' => $item->sucursal,
				'almacen' => $item->almacen,
			];
		}
		return response()->json(['data' => $data]);
	}
}
