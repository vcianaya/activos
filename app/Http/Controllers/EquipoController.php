<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Response;
use Excel;
use Input;
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
		$this->validate($request, [
			'categoria' => 'required',
			'codigo' => 'required',
			'marca' => 'required',
			'modelo' => 'required',
			'datepicker' => 'required',
			'sucursal' => 'required',
			'almacen' => 'required'
		]);

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
		->select('equipo.id','equipo.codigo_siaf','equipo.marca','equipo.modelo','equipo.modelo_procesador','equipo.fecha_ingreso','equipo.descripcion','sucursal.nombre as sucursal','almacen.nombre as almacen')
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
				'accion' => 
				'<div class="btn-group">
						<a href="#" data-balloon="Editar Equipo" data-balloon-pos="up" type="button" class="btn btn-warning edit-equipo">
							<i class="fa fa-edit"></i>
						</a>
				</div>'
			];
		}
		return response()->json(['data' => $data]);
	}

	public function editar_equipo($id_equipo)
	{
		$equipo = Equipo::find($id_equipo);
		$categoria = Categoria::all();
		$sucursal = Sucursal::where('estado',1)->get();
		$almacen = Almacen::join('sucursal','almacen.sucursal','=','sucursal.id')
		->where('almacen.id','=', $equipo->almacen)
		->select('almacen.id as id_almacen','sucursal.id as id_sucursal')
		->first();
	 
		return Response::json(view('equipos.editar_equipo', ['equipo'=>$equipo,'categoria'=>$categoria,'sucursal'=>$sucursal,'almacen'=>$almacen])->render());
	}

	public function get_almacenes_sucursal($id_sucursal, $id_almacen)
	{
		$almacen = Almacen::where('sucursal',$id_sucursal)->get();
		foreach ($almacen as $item) {
			$data[] = [
				'id' => $item->id,
				'text' => $item->nombre,
				'selected' => ( $id_almacen == $item->id)? 'true':''
			];
		}
		return response()->json(['data' => $data]);
	}

	public function update_equipo(Request $request)
	{
		$this->validate($request, [
			'id_equipo' => 'required',
			'categoria' => 'required',
			'codigo' => 'required',
			'marca' => 'required',
			'modelo' => 'required',
			'datepicker' => 'required',
			'sucursal' => 'required',
			'almacen' => 'required'
		]);

		$equipo = Equipo::find($request->id_equipo);
		$equipo->categoria = $request->categoria;
		$equipo->codigo_siaf = $request->codigo;
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
		return response()->json(['type' => 'warning','icon'=>'fa fa-save','message'=>'Datos actualizados']);
	}

	public function registro_masivo_equipos(Request $request)
	{
		$this->validate($request, [
			'id_categoria' => 'required',
			'id_sucursal' => 'required',
			'id_almacen' => 'required',
			'file_excel' => 'required|mimes:xlsx'
		]);

		if($request->hasFile('file_excel')){
			Excel::load($request->file('file_excel')->getRealPath(), function ($reader) {
				foreach ($reader->toArray() as $key => $row) {
					$data['title'] = $row['title'];
					$data['description'] = $row['description'];
				}
			});
		}
	}
}
