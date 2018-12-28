@extends('master')

@section('css')
<link rel="stylesheet" href="{{ url('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ url('template/bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>devolución de activos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-5">

				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">FUNCIONARIOS</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="funcionarios-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th>Funcionario</th>
									<th>Sucursal</th>
									<th>Ver Activos</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($funcionarios as $item)
								<tr id="{{ $item->id }}">
									<td>{{ $item->nombre.' '.$item->ap_paterno.' '.$item->ap_materno }}</td>
									<td>{{ $item->sucursal }}</td>
									<td>
										<button type="button" class="btn btn-info btn-xs get_activos"><i class="fa fa-eye"></i></button>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Funcionario</th>
									<th>Sucursal</th>
									<th>Ver activos</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title" id="title-funcionario">EQUIPOS ASIGNADOS</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="asignados-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>PROCESADOR</th>
									<th>FECHA ASIGNACION</th>
									<th>DESCRIPCION</th>
									<th>DEVOLVER</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>PROCESADOR</th>
									<th>FECHA ASIGNACION</th>
									<th>DESCRIPCION</th>
									<th>DEVOLVER</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="box box-warning" id="container-table">
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('js')
<script src="{{ url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('template/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ url('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		asignados_table = $('#asignados-table');
		funcionario_table = $('#funcionarios-table').DataTable({
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2],
				"className": "text-center",
			},],
		});

		asignados_table.DataTable({
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			}
		});

		funcionario_table.on('click', '.get_activos', function (e) {
			e.preventDefault();
			data = funcionario_table.row($(this).parents('tr')).data();
			$('#title-funcionario').text("Activos del funcionario "+data[0]);
			id_funcionario = $(this).closest('tr').attr('id');
			$.ajax({
				url: "{{ url('get_activos_asignados') }}/"+id_funcionario,
				success:function(response){
					console.log(response);
				}
			});
			asignados_table.dataTable().fnDestroy()

			asignados_table.DataTable({
				"processing": true,
				"aaSorting": [],
				"ajax": "{{ url('get_activos_asignados') }}/"+id_funcionario,
				"language": {
					"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
				},
				"columns": [
				{ "data": "codigo_siaf" },
				{ "data": "marca" },
				{ "data": "modelo_procesador" },
				{ "data": "fec_asignacion" },
				{ "data": "descripcion" },
				{ "data": "accion" },
				],
			});
		});
	});
</script>
@endsection