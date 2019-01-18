@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>creacion de categorias</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">LISTADO DE ACTIVOS</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="equipo-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>MODELO</th>
									<th>PROCESADOR</th>
									<th>FECHA INGRESO</th>
									<th>DESCRIPCION</th>
									<th>SUCURSAL</th>
									<th>ALMACEN</th>
									<th>ASIGNADO A:</th>
									<th>ACCION</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>MODELO</th>
									<th>PROCESADOR</th>
									<th>FECHA INGRESO</th>
									<th>DESCRIPCION</th>
									<th>SUCURSAL</th>
									<th>ALMACEN</th>
									<th>ASIGNADO A:</th>
									<th>ACCION</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('js')
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

		table_equipos = $('#equipo-table').DataTable({
			"processing": true,
			"aaSorting": [],
			"ajax": "{{ url('get_equipos_mantenimiento') }}",
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2],
				"className": "text-center",
			},],
			"columns": [
			{ "data": "codigo_siaf" },
			{ "data": "marca" },
			{ "data": "modelo" },
			{ "data": "modelo_procesador" },
			{ "data": "fecha_ingreso" },
			{ "data": "descripcion" },
			{ "data": "sucursal" },
			{ "data": "almacen" },
			{ "data": "estado" },
			{ "data": "accion" }
			],
		});

		table_equipos.on('click', '.mantenimiento', function (e) {
			e.preventDefault();
			id_equipo = $(this).closest('tr').attr('id');
			modal.find('h4').text('FORMULARIO FALLA TECNICA');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			$.ajax({
				url: "{{ url('formulario_mantenimiento') }}/"+id_equipo,
				success:function(response){
					body = modal.find('.modal-body');
					body.html(response);
					modal.find('.btn-primary').off().on('click',function(e){
						e.preventDefault();
						$.ajax({
							url: '{{ url('save_falla_tecnica') }}',
							type: 'POST',
							data: new FormData($("#frm_falla_tecnica")[0]),
							contentType: false,
							cache: false,
							processData: false,
							success: function (result) {
								modal.modal('hide');
								notify(result.type, result.icon, result.message);
								table_equipos.ajax.reload();
							},
							error: function (error) {
								error = error.responseJSON;
								(error.detalle)?
								$("#detalle").closest('div').addClass('has-error').find('.help-block').text(error.detalle[0]):
								$("#detalle").closest('div').removeClass('has-error').find('.help-block').text('');
								(error.datepicker)?
								$("#err-datepicker").closest('div').addClass('has-error').find('.help-block').text('El campo fecha de ingreso es requerido'):
								$("#err-datepicker").closest('div').removeClass('has-error').find('.help-block').text('');
							}
						});
					});
				}
			});
			modal.modal('show');
		});

		table_equipos.on('click', '.reparacion', function (e) {
			e.preventDefault();
			id_equipo = $(this).closest('tr').attr('id');
			modal.find('h4').text('REGISTRO DE REPARACION');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			body = modal.find('.modal-body');
			body.html('');
			$.ajax({
				url: "{{ url('register_reparacion') }}/"+id_equipo,
				success:function(response){
					body = modal.find('.modal-body');
					body.html(response);
					modal.modal('show');
					modal.find('.btn-primary').off().on('click',function(e){
						e.preventDefault();
						$.ajax({
							url: '{{ url('save_reparacion') }}',
							type: 'POST',
							data: new FormData($("#frm_reparacion")[0]),
							contentType: false,
							cache: false,
							processData: false,
							success: function (result) {
								modal.modal('hide');
								notify(result.type, result.icon, result.message);
								table_equipos.ajax.reload();
							},
							error: function (error) {
								error = error.responseJSON;
								(error.detalle)?
								$("#detalle").closest('div').addClass('has-error').find('.help-block').text(error.detalle[0]):
								$("#detalle").closest('div').removeClass('has-error').find('.help-block').text('');
								(error.datepicker)?
								$("#err-datepicker").closest('div').addClass('has-error').find('.help-block').text('El campo fecha de ingreso es requerido'):
								$("#err-datepicker").closest('div').removeClass('has-error').find('.help-block').text('');
							}
						});
					});
				}
			});
		});

		table_equipos.on('click', '.ver_mas', function (e) {
			e.preventDefault();
			id_equipo = $(this).closest('tr').attr('id');
			modal.find('h4').text('HISTORIAL DE FALLAS DEL EQUIPO');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			body = modal.find('.modal-body');
			body.html('');
			$.ajax({
				url: "{{ url('show_fallas') }}/"+id_equipo,
				success:function(response){
					body = modal.find('.modal-body');
					body.html(response);
					modal.modal('show');
					modal.find('.btn-primary').off().on('click',function(e){
						e.preventDefault();
						modal.modal('hide');
					});
				}
			});
		});

	})
</script>
@endsection