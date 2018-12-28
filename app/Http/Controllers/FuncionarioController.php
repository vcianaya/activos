<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use PDF;
use Carbon\Carbon;

use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// MODELS
use App\Sucursal;
use App\Area;
use App\Funcionario;
use App\Cargo;
use App\Equipo;
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

	public function update_funcionario(Request $request)
	{
		$funcionario = Funcionario::find($request->id);
		if ($request->ci != ''){
			$funcionario->ci = $request->ci;
		}
		if ($request->expedido != ''){
			$funcionario->expedido = $request->expedido;
		}
		if ($request->nombre != ''){
			$funcionario->nombre = $request->nombre;
		}
		if ($request->apellidoPaterno != ''){
			$funcionario->ap_paterno = $request->apellidoPaterno;
		}
		if ($request->apellidoMaterno != ''){
			$funcionario->ap_materno = $request->apellidoMaterno;
		}
		if ($request->fechaNacimiento != ''){
			$funcionario->fec_nac = $request->fechaNacimiento;
		}
		if ($request->genero != ''){	
			$funcionario->genero = $request->genero;
		}
		if ($request->departamento != ''){
			$funcionario->departamento = $request->departamento;
		}
		if ($request->ciudad != ''){
			$funcionario->ciudad = $request->ciudad;
		}
		if ($request->zona != ''){
			$funcionario->zona = $request->zona;
		}
		if ($request->calle != ''){	
			$funcionario->calle = $request->calle;
		}
		if ($request->nro_puerta != ''){	
			$funcionario->nro_puerta = $request->nro_puerta;
		}
		if ($request->telefono != ''){
			$funcionario->telefono = $request->telefono;
		}
		if ($request->celular != ''){
			$funcionario->celular = $request->celular;
		}
		if ($request->email != ''){
			$funcionario->email = $request->email;
		}
		if (!is_null($request->file('foto'))) {
			Storage::delete($funcionario->foto);
			$funcionario->foto = $request->file('foto')->store('foto_funcionario');
		}
		$funcionario->estado = 1;
		if ($request->sucursal != ''){
			$funcionario->sucursal = $request->sucursal;
		}
		if ($request->area != ''){
			$funcionario->area = $request->area;
		}
		if ($request->cargo != ''){
			$funcionario->cargo = $request->cargo;
		}
		$funcionario->save();
		Session::flash('success','Datos Actualizados');
		return back();
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

	public function get_activos_pdf($id_funcionario)
	{
		$funcionario =  Funcionario::join('sucursal','sucursal.id','=','funcionario.sucursal')
		->join('cargo','cargo.id','=','funcionario.cargo')
		->join('area','area.id','=','funcionario.area')
		->select('funcionario.ci','funcionario.expedido','funcionario.nombre','funcionario.ap_paterno','funcionario.ap_materno','funcionario.fec_nac','funcionario.genero','funcionario.departamento','funcionario.ciudad','funcionario.zona','funcionario.calle','funcionario.nro_puerta','funcionario.celular','sucursal.nombre as sucursal','cargo.cargo','area.nombre as area')
		->where('funcionario.id',$id_funcionario)
		->first();
		$equipos = Equipo::join('equipo_asignado','equipo.id','=','equipo_asignado.equipo')
							->select('equipo.*')
							->where('equipo_asignado.funcionario',$id_funcionario)
							->get();

		PDF::SetTitle('DETALLE FUNCIONARIO SIN');
		PDF::SetSubject('Servicio de Impuestos Nacionales');
		PDF::SetMargins(25, 15, 15);
		
		PDF::setHeaderCallback(function($pdf) {
		 $pdf->Image(public_path('/pdf/impuestos.png'), 130, 10, 70, 10, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
		 $pdf->Image(public_path('/pdf/escudo.png'), 10, 10, 70, 10, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
		 $pdf->ln(18);
		 $pdf->SetFont('helvetica', 'B', 12);
		 $pdf->Cell(0, 10, 'SISTEMA DE ACTIVOS FIJOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		 $pdf->ln(6);
		 $pdf->SetFont('helvetica', 'B', 11);
		 $pdf->Cell(0, 10, 'DETALLE DE ACTIVOS DEL FUNCIONARIO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(40,11, 'FUNCIONARIO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(130,11, $funcionario->nombre.' '.$funcionario->ap_paterno.' '.$funcionario->ap_materno, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(40,11, 'C.I.', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(50,11, $funcionario->ci, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(25,11, 'CELULAR', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(55,11, $funcionario->celular, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetDrawColor(0, 0, 0);
		PDF::SetLineWidth(0.3);
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(40,11, 'DIRECCION FUNCIONARIO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(130,11, $funcionario->ciudad.' Z/ '.$funcionario->zona.' C/ '.$funcionario->calle.' /Nro. '.$funcionario->nro_puerta, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetDrawColor(0, 0, 0);
		PDF::SetLineWidth(0.3);
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(40,11, 'SUCURSAL', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(130,11, $funcionario->sucursal, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::ln();
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetFont('', 'B',10);
		PDF::MultiCell(40,11, 'CARGO', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(50,11, $funcionario->cargo, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::MultiCell(25,11, 'AREA', 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0,0,0);
		PDF::MultiCell(55,11, $funcionario->area, 1, 'C', 1, 0, '', '', true, 0, false, true, 11, 'M');
		PDF::Ln();
		PDF::Ln();

		PDF::SetFillColor(8, 93, 178);
		PDF::SetTextColor(255);
		PDF::SetLineWidth(0.3);
		PDF::SetFont('helvetica', 'B', 8);
		// Header
		PDF::Cell(20, 7, 'COD. SIAF', 1, 0, 'C', 1);
		PDF::Cell(37, 7, 'MARCA', 1, 0, 'C', 1);
		PDF::Cell(47, 7, 'NRO. SERIE', 1, 0, 'C', 1);
		PDF::Cell(67, 7, 'DESCRIPCION', 1, 0, 'C', 1);
		PDF::Ln();
		// Color and font restoration
		PDF::SetFillColor(255, 255, 255);
		PDF::SetTextColor(0);
		PDF::SetFont('');
		foreach ($equipos as $item) {
			PDF::MultiCell(20, 6, $item->codigo_siaf, 'LRB', 0, 'L', 0);
			PDF::MultiCell(37, 6, $item->marca, 'LRB', 0, 'L', 0);
			PDF::MultiCell(47, 6, $item->nro_serie, 'LRB', 0, 'L', 0);
			PDF::MultiCell(67, 6, $item->descripcion, 'LRB', 0, 'C', 0);
			PDF::Ln();
		}
		// PDF::Cell(array_sum($w), 0, '', 'T');

		PDF::Output('reporte_activos.pdf');
	}
}