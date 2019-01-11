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
					<div class="box-header with-border">
						<h3 class="box-title">EQUIPOS A DEVOLVER</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="devolucion-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>PROCESADOR</th>
									<th>DESCRIPCION</th>
									<th>FECHA ASIGNACION</th>
									<th>Observacion Devolucion</th>
									<th>ACCION</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>PROCESADOR</th>
									<th>DESCRIPCION</th>
									<th>FECHA ASIGNACION</th>
									<th>Observacion Devolucion</th>
									<th>ACCION</th>
								</tr>
							</tfoot>
						</table>
					</div>
					<button id="submit_devolucion" type="button" class="btn btn-block btn-primary">DEVOLVER ACTIVOS</button>
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

		modal = $('#modal');
		function notify(type, icon, message) {
			$.notify({
						// options
						icon: icon,
						message: message
					}, {
						element: 'body',
						position: null,
						type: type,
						allow_dismiss: true,
						placement: {
							from: "bottom",
							align: "right"
						},
						offset: 20,
						spacing: 10,
						z_index: 1031,
						timer: 10000,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						}
					});
		}
	// TABLA DE EQUIPOS DEVUELTOS
	asignados = [];
	devolucion_table = $('#devolucion-table');
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

	data_asignados_table = asignados_table.DataTable({
		"language": {
			"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
		}
	});

	data_devolucion_table = devolucion_table.DataTable({
		"language": {
			"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
		}
	});

	funcionario_table.on('click', '.get_activos', function (e) {
		e.preventDefault();
		data = funcionario_table.row($(this).parents('tr')).data();
		$('#title-funcionario').text("Activos del funcionario "+data[0]);
		id_funcionario = $(this).closest('tr').attr('id');

		asignados_table.dataTable().fnDestroy()

		data_asignados_table = asignados_table.DataTable({
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

	asignados_table.on('click', '.devolver_activo', function (e) {
		e.preventDefault();
		id_row = $(this).closest('tr').attr('id');
		id_asignacion = $(this).closest('tr').attr('id');
		row = data_asignados_table.row($(this).parents('tr'));
		data = data_asignados_table.row($(this).parents('tr')).data();
		modal.find('.modal').removeClass("bs-example-modal-sm");
		modal.find('.modal-dialog').removeClass("modal-sm");
		modal.find('h4').text('DEVOLVER ACTIVO');
		modal.find('.btn-default').text('Cancelar');
		modal.find('.btn-primary').text('Devolver');
		$.ajax({
			url: "{{ url('get_activo_asignado') }}/"+id_asignacion,
			success:function(response){
				body = modal.find('.modal-body');
				body.html(response);
			}
		});

		modal.find('.btn-primary').off().on('click',function(e){
			observacion = body.find('#observacion_devolucion').val();
				row.remove().draw(false);
				data_devolucion_table.row.add([
					data.codigo_siaf,
					data.marca,
					data.modelo_procesador,
					data.descripcion,
					data.fec_asignacion,
					observacion,
					'<button type="button" class="btn btn-warning btn-sm quitar_activo" data-balloon="Quitar de la lista" data-balloon-pos="up"><i class="fa fa-ban"></i></button>',	
					]).node().id = id_row;
				data_devolucion_table.draw(false);
				objAsignado = { id: id_row, observacion: observacion}
				asignados.push(objAsignado);
				console.log(asignados);
				modal.modal('hide');
			});

		modal.modal('show');

	});

	devolucion_table.on('click', '.quitar_activo', function (e) {
		e.preventDefault();
		id_row = $(this).closest('tr').attr('id');
		row_devolucion_table = data_devolucion_table.row($(this).parents('tr'));
		data1 = data_devolucion_table.row($(this).parents('tr')).data();
				row_devolucion_table.remove().draw(false);
				data_asignados_table.row.add({
					"DT_RowId": id_row,
					"codigo_siaf" : data1[0],
					"marca" : data1[1],
					"modelo_procesador" : data1[2],
					"fec_asignacion" : data1[3],
					"descripcion" : data1[4],
					"accion" : '<div class="btn-group"><a data-balloon="Devolver Activo" data-balloon-pos="up" type="button" class="btn btn-danger devolver_activo"><i class="fa fa-eject"></i></a></div>'
					}).draw(false);
				asignados.splice(asignados.indexOf(asignados.findIndex((e) => e.id === id_row)), 1);
				console.log(asignados);
	});
		// DEVOLVER EQUIPOS
		$("#submit_devolucion").click(function(e) {
			modal.find('.modal').addClass("bs-example-modal-sm");
			modal.find('.modal-dialog').addClass("modal-sm");
			modal.find('h4').text('DEVOLVER ACTIVOS');
			body = modal.find('.modal-body');
			body.html('Esta seguro de devolver los activos..?');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();
				if (asignados.length>0) {
					$.ajax({
						url: '{{ url('save_devolver_activos') }}',
						type: 'post',
						dataType: 'json',
						contentType: 'application/json',
						data: JSON.stringify({asignados: asignados}),
						success: function (result) {
							modal.modal('hide');
							notify(result.type, result.icon, result.message);
							 $('#devolucion-table').dataTable().fnClearTable();
						}
					})
				}else{
					modal.modal('hide');
					notify('danger', 'fa fa-frown-o', 'No tiene activos en la lista para devolver');
				}
			});
			modal.modal('show');
		});

		
	});
</script>
@endsection