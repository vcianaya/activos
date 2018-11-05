<?php

namespace App\Http\Controllers;
// HELPERS
use Session;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//MODELS
use App\Sucursal;
use App\Area;
use App\Almacen;
class SucursalController extends Controller
{
	public function registrar_sucursal()
	{
		$sucursal = Sucursal::all();
		return view('sucursal.registrar_sucursal',['sucursal'=>$sucursal]);
	}

	public function save_sucursal(Request $request)
	{
		$this->validate($request, [
			'nit' => 'required|unique:sucursal',
			'nombre' => 'required',
			'departamento' => 'required',
			'ciudad' => 'required',
			'foto' => 'required|mimes:jpeg,jpg,png'
		]);

		$sucursal = new Sucursal();
		$sucursal->nit = strtoupper($request->nit);
		$sucursal->nombre = strtoupper($request->nombre);
		$sucursal->departamento = strtoupper($request->departamento);
		$sucursal->ciudad = strtoupper($request->ciudad);
		$sucursal->zona = strtoupper($request->zona);
		$sucursal->calle = strtoupper($request->calle);
		$sucursal->num_puerta = strtoupper($request->num_puerta);
		$sucursal->telefono = strtoupper($request->telefono);
		$sucursal->celular = strtoupper($request->celular);
		$sucursal->email = $request->email;
		$sucursal->fax = strtoupper($request->fax);
		$sucursal->estado = 1;
		$sucursal->foto = $request->file('foto')->store('foto_funcionario');
		$sucursal->user = Auth::user()->id;
		$sucursal->save();

		Session::flash('success','Sucursal Creada');
		return back();
	}

	public function editar_sucursal($id_sucursal)
	{
		$sucursal = Sucursal::find($id_sucursal);
		$sucursales = Sucursal::all();
		return view('sucursal.editar_sucursal',['sucursales'=>$sucursales, 'sucursal'=>$sucursal]);
	}

	public function update_sucursal(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
			'nombre' => 'required',
			'departamento' => 'required',
			'ciudad' => 'required'
		]);

		$sucursal = Sucursal::find($request->id);
		if ($request->nit != ''){
			$sucursal->nit = strtoupper($request->nit);
		}
		if ($request->nombre != ''){
			$sucursal->nombre = strtoupper($request->nombre);
		}

		if ($request->departamento != ''){
			$sucursal->departamento = strtoupper($request->departamento);
		}
		if ($request->ciudad != ''){
			$sucursal->ciudad = strtoupper($request->ciudad);
		}
		if ($request->zona != ''){
			$sucursal->zona = strtoupper($request->zona);
		}
		if ($request->calle != ''){
			$sucursal->calle = strtoupper($request->calle);
		}
		if ($request->num_puerta != ''){
			$sucursal->num_puerta = strtoupper($request->num_puerta);
		}
		if ($request->telefono != ''){
			$sucursal->telefono = strtoupper($request->telefono);
		}
		if ($request->celular != ''){
			$sucursal->celular = strtoupper($request->celular);
		}
		if ($request->email != ''){
			$sucursal->email = $request->email;
		}
		if ($request->fax != ''){
			$sucursal->fax = strtoupper($request->fax);
		}
		$sucursal->estado = 1;
		if (!is_null($request->file('foto'))) {
			Storage::delete($sucursal->foto);
			$sucursal->foto = $request->file('foto')->store('foto_funcionario');
		}
		$sucursal->user = Auth::user()->id;
		$sucursal->save();


		Session::flash('success','Sucursal Actualizada');
		return back();
	}

	public function delete_sucursal($id_sucursal)
	{
		$sucursal = Sucursal::find($id_sucursal);
		$sucursal->estado = 0;
		$sucursal->save();

		Session::flash('error','Sucursal eliminada');
		return back();
	}

	public function restore_sucursal($id_sucursal)
	{
		$sucursal = Sucursal::find($id_sucursal);
		$sucursal->estado = 1;
		$sucursal->save();

		Session::flash('success','Sucursal restaurada');
		return back();
	}

	public function sucursal($id_sucursal)
	{
		$sucursal = Sucursal::find($id_sucursal);
		if ($sucursal->estado == 1) {
			$area = Area::where('sucursal', $sucursal->id)->count();
			$almacen = Almacen::where('sucursal', $sucursal->id)->count();
			return view('sucursal.sucursal',['sucursal'=>$sucursal,'total_areas'=>$area,'total_almacenes'=>$almacen]);
		}else{
			return back();
		}
	}

	public function create_area(Request $request)
	{
		$this->validate($request, [
			'area' => 'required',
			'descripcion' => 'required'
		]);
		$area = new Area();
		$area->nombre = strtoupper($request->area);
		$area->descripcion = strtoupper($request->descripcion);
		$area->sucursal = $request->sucursal;
		$area->save(); 
		// Session::flash('success','Area Creada');
		// return back();
		return response()->json($request->all());
	}

	public function get_areas($id_sucursal)
	{
		$areas_data = Area::where('sucursal',$id_sucursal)->get();
		$area = [];
		foreach ($areas_data as $item) {
			$area[] = [
				'DT_RowId' => $item->id,
				'nombre' => $item->nombre,
				'descripcion' => $item->descripcion,
				'accion' => ($item->estado == 1)?
				'<div class="btn-group">
						<a href="#" data-balloon="Editar Area" data-balloon-pos="up" type="button" class="btn btn-warning edit-area">
							<i class="fa fa-edit"></i>
						</a>
						<a href="#" data-balloon="Eliminar Area" data-balloon-pos="up" type="button" class="btn btn-danger eliminar-area">
							<i class="fa fa-trash"></i>
						</a>
				</div>':
				'<div class="btn-group">
						<a href="#" data-balloon="Restaurar Area" data-balloon-pos="up" type="button" class="btn btn-success restaurar-area">
							<i class="fa fa-thumbs-o-up"></i>
						</a>
				</div>',
				'estado' => $item->estado
			];
		}
		return response()->json(['data' => $area]);
	}

	public function edit_area($id_area)
	{
		$area = Area::find($id_area);
		return Response::json(view('sucursal.edit_area', ['area'=>$area])->render());
	}

	public function update_area(Request $request)
	{
		$this->validate($request, [
			'area' => 'required',
			'descripcion' => 'required'		
		]);
		$area = Area::find($request->id_area);
		$area->nombre = strtoupper($request->area);
		$area->descripcion = strtoupper($request->descripcion);
		$area->save();
		return response()->json(['type' => 'warning','icon'=>'fa fa-edit','message'=>'Area Actualizada']);
	}
	public function delete_area($id_area)
	{
		$area = Area::find($id_area);
		$area->estado = 0;
		$area->save();
		return response()->json(['type' => 'danger','icon'=>'fa fa-edit','message'=>'Area eliminada']);
	}

	public function restore_area($id_area)
	{
		$area = Area::find($id_area);
		$area->estado = 1;
		$area->save();
		return response()->json(['type' => 'success','icon'=>'fa fa-edit','message'=>'Area restaurada']);
	}

	public function create_almacen(Request $request)
	{
		$this->validate($request, [
			'almacen' => 'required',
			'descripcion' => 'required'
		]);
		$almacen = new Almacen();
		$almacen->nombre = strtoupper($request->almacen);
		$almacen->descripcion = strtoupper($request->descripcion);
		$almacen->sucursal = $request->sucursal;
		$almacen->save();
		return response()->json(['type' => 'success','icon'=>'fa fa-edit','message'=>'Almacen Creado']);
	}

	public function get_almacenes($id_sucursal)
	{
		$almacenes_data = Almacen::where('sucursal',$id_sucursal)->get();
		$almacen = [];
		foreach ($almacenes_data as $item) {
			$almacen[] = [
				'DT_RowId' => $item->id,
				'nombre' => $item->nombre,
				'descripcion' => $item->descripcion,
				'accion' =>
				'<div class="btn-group">
						<a href="#" data-balloon="Editar Almacen" data-balloon-pos="up" type="button" class="btn btn-warning edit-almacen">
							<i class="fa fa-edit"></i>
						</a>
						<a href="#" data-balloon="Ver Almacen" data-balloon-pos="up" type="button" class="btn btn-info ver-equipos">
							<i class="fa fa-folder-open"></i>
						</a>
				</div>'

			];
		}
		return response()->json(['data' => $almacen]);
	}
}
