<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;
use Response;
use Excel;
use Input;
use PDF;
use Carbon\Carbon;
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
				<a href="#" data-balloon="Imprimir Detalle" data-balloon-pos="up" type="button" class="btn btn-info edit-equipo">
				<i class="fa fa-print"></i>
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
		global $data;

		if($request->hasFile('file_excel')){
			Excel::load($request->file('file_excel')->getRealPath(), function ($reader) {
				$GLOBALS['excel'] = $reader->get();
			});
		}

		$categoria = Categoria::find($request->id_categoria);
		$c=0;
		foreach ($GLOBALS['excel'] as $item) {
			$equipo = new Equipo();
			$equipo->categoria = $request->id_categoria;
			$equipo->descripcion = $item->descripcion;
			$equipo->codigo_siaf = $categoria->codigo;
			$equipo->nro_serie = $item->serie;
			$equipo->marca = strtoupper($item->marca);
			$equipo->modelo = strtoupper($item->modelo);
			$equipo->modelo_procesador = $item->procesador;
			$equipo->fecha_ingreso = Carbon::now()->format('Y-m-d');
			$equipo->almacen = $request->id_almacen;
			$equipo->estado_equipo = 1;
			$equipo->observacion = $item->observaciones;
			$equipo->save();
			$c = $c+1;
		}
		
		return response()->json(['type' => 'success','icon'=>'fa fa-save','message'=>$c.' Registros ingresados']);
	}

	public function descargar_formato()
	{
		$filePath = public_path('storage/excel/FORMATO_EXCEL.xlsx');
		$headers = ['Content-Type: application/xlsx'];
		return response()->download($filePath,'FORMATO_EXCEL.xlsx', $headers);
	}

	public function detalle_equipo()
	{
		PDF::SetTitle('TCPDF Example 001');
		PDF::SetSubject('TCPDF Tutorial');
		PDF::SetMargins(25, 15, 15);
		
		PDF::setHeaderCallback(function($pdf) {
			$pdf->Image(public_path('/pdf/impuestos.png'), 130, 10, 70, 10, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$pdf->Image(public_path('/pdf/escudo.png'), 10, 10, 70, 10, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$pdf->ln(18);
			$pdf->SetFont('helvetica', 'B', 12);
			$pdf->Cell(0, 10, 'SISTEMA DE ACTIVOS FIJOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->ln(6);
			$pdf->SetFont('helvetica', 'B', 11);
			$pdf->Cell(0, 10, 'FICHA TECNICA DE EQUIPOS COMPUTACIONALES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->ln(5);
			$pdf->SetFont('helvetica', '', 10);
			$pdf->Cell(0, 10, 'Fecha y hora de impresion: '.Carbon::now()->format('Y-m-d H:s'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
		});
		
		PDF::setFooterCallback(function($pdf){
			$pdf->SetY(-15);
			$pdf->SetFont('helvetica', 'I', 8);
			$pdf->Image(public_path('/pdf/bandera.jpg'), 10, 280, 190, 1.4, 'jpg', '', 'T', false, 100, '', false, false, 0, false, false, false);
			$pdf->ln(1);
			$pdf->Cell(0, 10, 'Page - '.$pdf->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$pdf->ln(1);
			$pdf->Cell(0, 10, 'Servicio de Impuestos Nacionales Tus Impuestos tu pais.', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		});

		PDF::AddPage();

		// Colors, line width and bold font
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetDrawColor(0, 0, 0);
		PDF::SetLineWidth(0.3);
		
		PDF::ln(35);
		PDF::SetFont('', 'B',12);
		PDF::Cell(0, 7, 'CAATEGORIA DEL EQUIPO', 1, 0, 'C', 2);
		PDF::ln();
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(30,11, 'CODIGO SIAF', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(40,11, 'var_codigo_siaf', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(25,11, 'SUCURSAL', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(75,11, 'var_codigo_siaf', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(30,11, 'FECHA REGISTRO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(40,11, 'var_fecha_registro', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(25,11, 'ALMACEN', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(75,11, 'var_almacen', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'MARCA', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_marca', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'MODELO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_modelo', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'PROCESADOR', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_procesador', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'ESTADO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_estado', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'OBSERVACION', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_observacion', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(30,11, 'ASIGNADO A:', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(140,11, 'var_asignado', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		
/*
		PDF::Cell(30, 7, 'Codigo SIAF', 1, 0, 'C', 2);
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::Cell(55, 7, 'codigo_siaf', 1, 0, 'C', 2);

		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::Cell(40, 7, 'SUCURSAL', 1, 0, 'C', 2);
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::Cell(45, 7, 'var_sucursal', 1, 0, 'C', 2);
*/
		/**
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::Cell(50, 7, 'Codigo SIAF', 1, 0, 'C', 2);
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::Cell(120, 7, 'codigo_siaf', 1, 0, 'C', 2);
		*/
		PDF::Output('hello_world.pdf');
	}
}



