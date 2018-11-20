<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Illuminate\Support\Facades\Storage;
//MODELS
use App\Categoria;
class EquipoController extends Controller
{
	public function registrar_equipo()
	{
		return view('equipos.crear_equipo');
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
		$categoria = Categoria::join('equipo', 'categoria.id', '=', 'equipo.categoria')
		->select('categoria.id','categoria.codigo','categoria.nombre','categoria.vida_util','categoria.foto',DB::raw('count(equipo.id) as total'))
		->groupBy('categoria.id')
		->get();
		$data = [];
		foreach ($categoria as $item) {
			$data[] = [
				'DT_RowId' => $item->id,
				'codigo' => $item->codigo,
				'nombre' => $item->nombre,
				'vida_util' => $item->vida_util,
				'foto' => '<img src="'.URL::to("/storage/".$item->foto).'" width="100rem"   height="100rem">',
				'total_equipos' => $item->total,
				'accion' => 
				'<div class="btn-group">
						<a href="#" data-balloon="Editar Area" data-balloon-pos="up" type="button" class="btn btn-warning edit-area">
							<i class="fa fa-edit"></i>
						</a>
						<a href="#" data-balloon="Eliminar Area" data-balloon-pos="up" type="button" class="btn btn-danger eliminar-area">
							<i class="fa fa-trash"></i>
						</a>'
			];
		}
		return response()->json(['data' => $data]);
	}
}
