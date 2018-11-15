@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>Sucursal {{ $sucursal->nombre }}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="img-responsive img-circle" src="{{ url('storage/'.$sucursal->foto) }}" alt="User profile picture">
						<h3 class="profile-username text-center">{{ $sucursal->nombre }}</h3>
						<p class="text-muted text-center">Creado en fecha: {{ $sucursal->created_at }}</p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Funcionarios</b> <a class="pull-right">1,322</a>
							</li>
							<li class="list-group-item">
								<b>Areas</b> <a class="pull-right">{{ $total_areas }}</a>
							</li>
							<li class="list-group-item">
								<b>Almacenes</b> <a class="pull-right">{{ $total_almacenes }}</a>
							</li>
						</ul>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">CREACION DE AREAS</h3>
					</div>
					<form role="form" id="frm_area">
						<div class="box-body">
							<input type="hidden" name="sucursal" value="{{ $sucursal->id }}">
							<div class="form-group">
								<label class="control-label">Area <i class="required">*</i></label>
								<input id="area" name="area" type="text" class="form-control" placeholder="Legal">
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion <i class="required">*</i></label>
								<input id="area_descripcion" name="descripcion" type="text" class="form-control" placeholder="Area Legal de impuestos nacioanles">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="box-footer">
							<button id="btn_submit_area" class="btn btn-primary">Crear</button>
						</div>
					</form>
				</div>

				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">LISTADO DE AREAS</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="table-area" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Area</th>
									<th>Descripcion</th>
									<th>Accion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Area</th>
									<th>Descripcion</th>
									<th>Accion</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">CREACION DE ALMACENES</h3>
					</div>
					<form role="form" id="frm_almacen">
						<div class="box-body">
							<input type="hidden" name="sucursal">
							<div class="form-group">
								<label class="control-label">Almacen <i class="required">*</i></label>
								<input id="almacen" type="text" class="form-control" placeholder="Almacen de El alto">
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion <i class="required">*</i></label>
								<input id="almacen_descripcion" name="descripcion" type="text" class="form-control" placeholder="Almacen de equipos computacionales">
								<span class="help-block"></span>
							</div>
						</div>
						<div class="box-footer">
							<button id="btn_submit_almacen" class="btn btn-primary">Crear</button>
						</div>
					</form>
				</div>

				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">LISTADO DE ALMACENES</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="table-almacen" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Almacen</th>
									<th>Descripcion</th>
									<th>Accion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Area</th>
									<th>Descripcion</th>
									<th>Accion</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</div>
		</section>
	</div>
	@endsection

	@section('js')
	<script type="text/javascript">
		$(document).ready(function() {
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
			table_area = $('#table-area').DataTable({
				"processing": true,
				"aaSorting": [],
				"ajax": "{{ url('get_areas/'.$sucursal->id) }}",
				"language": {
					"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
				},
				'fnRowCallback': function( nRow, aData, iDisplayIndex ) {
					if(aData.estado == 0){
						$(nRow).addClass('danger');
					}
					return nRow;
				},
				'columnDefs': [
				{
					"targets": [0,1,2],
					"className": "text-center",
				},],
				"columns": [
				{ "data": "nombre" },
				{ "data": "descripcion" },
				{ "data": "accion" },
				],
			});
			modal = $('#modal');
			//ENVIAR FORMULARIO
			$("#btn_submit_area").click(function(e) {
				e.preventDefault();
				modal.find('.modal').addClass("bs-example-modal-sm");
				modal.find('.modal-dialog').addClass("modal-sm");
				modal.find('h4').text('CREAR AREA');
				modal.find('p').text('Esta seguro de crear el area');
				modal.find('.btn-default').text('Cancelar');
				modal.find('.btn-primary').text('Aceptar');
				modal.find('.btn-primary').off().on('click',function(e){
					e.preventDefault();
					$.ajax({
						url: '{{ url('create_area') }}',
						type: 'post',
						dataType: 'json',
						data: {
							_token: '{{ csrf_token() }}',
							sucursal: '{{ $sucursal->id }}',
							area: $("#area").val(),
							descripcion: $("#area_descripcion").val()
						},
						success: function (result) {
							$("#area").closest('div').removeClass('has-error').find('.help-block').text('');
							$("#area_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
							table_area.ajax.reload();
							modal.modal('hide');
							$('#frm_area')[0].reset();
						},
						error: function (error) {
							error = error.responseJSON;
							(error.area)?
							$("#area").closest('div').addClass('has-error').find('.help-block').text(error.area[0]):
							$("#area").closest('div').removeClass('has-error').find('.help-block').text('');
							(error.descripcion)?
							$("#area_descripcion").closest('div').addClass('has-error').find('.help-block').text(error.descripcion[0]):
							$("#area_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
						}
					})
				});
				modal.modal('show');
			});

			//EDITAR AREA

			$("#table-area").on('click', '.edit-area', function (e) {
				e.preventDefault();
				modal.find('.modal').removeClass("bs-example-modal-sm");
				modal.find('.modal-dialog').removeClass("modal-sm");
				modal.find('h4').text('Editar Area');
				modal.find('p').text('');
				modal.find('.btn-default').text('Cancelar');
				modal.find('.btn-primary').text('Actualizar');
				id_sucursal = $(this).closest('tr').attr('id');
				$.ajax({
					url: "{{ url('edit_area') }}/"+id_sucursal,
					success:function(response){
						body = modal.find('.modal-body');
						body.html(response);
					}
				});
				modal.find('.btn-primary').off().on('click',function(e){
					e.preventDefault();
					$.ajax({
						url: '{{ url('update_area') }}',
						type: 'post',
						dataType: 'json',
						data: {
							_token: '{{ csrf_token() }}',
							id_area: body.find('#id_area').val(),
							area: body.find('#area').val(),
							descripcion: body.find('#area_descripcion').val()
						},
						success: function (result) {
							table_area.ajax.reload();
							modal.modal('hide');
							notify(result.type, result.icon, result.message);
						},
						error: function (error) {
							error = error.responseJSON;
							(error.area)?
							body.find('#area').closest('div').addClass('has-error').find('.help-block').text(error.area[0]):
							body.find("#area").closest('div').removeClass('has-error').find('.help-block').text('');
							(error.descripcion)?
							body.find("#area_descripcion").closest('div').addClass('has-error').find('.help-block').text(error.descripcion[0]):
							body.find("#area_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
						}
					})
				});
				modal.modal('show');
			});

			//ELIMINAR AREA
			$("#table-area").on('click', '.eliminar-area', function (e) {
				e.preventDefault();
				modal.find('.modal').addClass("bs-example-modal-sm");
				modal.find('.modal-dialog').addClass("modal-sm");
				modal.find('h4').text('Eliminar area');
				body.html('Esta Seguro de eliminar el area..?');
				modal.find('.btn-default').text('Cancelar');
				modal.find('.btn-primary').text('Aceptar');
				id_area = $(this).closest('tr').attr('id');

				modal.find('.btn-primary').off().on('click',function(e){
					e.preventDefault();
					$.ajax({
						url: "{{ url('delete_area') }}/"+id_area,
						success:function(response){
							table_area.ajax.reload();
							notify(response.type, response.icon, response.message);
							modal.modal('hide');
						}
					});


				});
				modal.modal('show');
			});

			//RESTAURAR AREA
			$("#table-area").on('click', '.restaurar-area', function (e) {
				e.preventDefault();
				id_area = $(this).closest('tr').attr('id');
				e.preventDefault();
				$.ajax({
					url: "{{ url('restore_area') }}/"+id_area,
					success:function(response){
						table_area.ajax.reload();
						notify(response.type, response.icon, response.message);
						modal.modal('hide');
					}
				});
			});
			
			// ALMACENES
			$("#btn_submit_almacen").click(function(e) {
				e.preventDefault();
				modal.find('.modal').addClass("bs-example-modal-sm");
				modal.find('.modal-dialog').addClass("modal-sm");
				modal.find('h4').text('CREAR ALMACEN');
				modal.find('p').text('Esta seguro de crear el almacen');
				modal.find('.btn-default').text('Cancelar');
				modal.find('.btn-primary').text('Aceptar');
				modal.find('.btn-primary').off().on('click',function(e){
					e.preventDefault();
					$.ajax({
						url: '{{ url('create_almacen') }}',
						type: 'post',
						dataType: 'json',
						data: {
							_token: '{{ csrf_token() }}',
							sucursal: '{{ $sucursal->id }}',
							almacen: $("#almacen").val(),
							descripcion: $("#almacen_descripcion").val()
						},
						success: function (result) {
							$("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
							$("#almacen_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
							table_almacen.ajax.reload();
							modal.modal('hide');
							notify(result.type, result.icon, result.message);
							$('#frm_almacen')[0].reset();
						},
						error: function (error) {
							error = error.responseJSON;
							(error.almacen)?
							$("#almacen").closest('div').addClass('has-error').find('.help-block').text(error.almacen[0]):
							$("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
							(error.descripcion)?
							$("#almacen_descripcion").closest('div').addClass('has-error').find('.help-block').text(error.descripcion[0]):
							$("#almacen_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
						}
					})
				});
				modal.modal('show');
			});
			// TABLE ALMACENES
			table_almacen = $('#table-almacen').DataTable({
				"processing": true,
				"aaSorting": [],
				"ajax": "{{ url('get_almacenes/'.$sucursal->id) }}",
				"language": {
					"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
				},
				'columnDefs': [
				{
					"targets": [0,1,2],
					"className": "text-center",
				},],
				"columns": [
				{ "data": "nombre" },
				{ "data": "descripcion" },
				{ "data": "accion" },
				],
			});
			//EDITAR AREA

			$("#table-almacen").on('click', '.edit-almacen', function (e) {
				e.preventDefault();
				modal.find('.modal').removeClass("bs-example-modal-sm");
				modal.find('.modal-dialog').removeClass("modal-sm");
				modal.find('h4').text('Editar Almacen');
				modal.find('p').text('');
				modal.find('.btn-default').text('Cancelar');
				modal.find('.btn-primary').text('Actualizar');
				id_almacen = $(this).closest('tr').attr('id');
				$.ajax({
					url: "{{ url('edit_almacen') }}/"+id_almacen,
					success:function(response){
						body = modal.find('.modal-body');
						body.html(response);
					}
				});
				modal.find('.btn-primary').off().on('click',function(e){
					e.preventDefault();
					$.ajax({
						url: '{{ url('update_almacen') }}',
						type: 'post',
						dataType: 'json',
						data: {
							_token: '{{ csrf_token() }}',
							id_almacen: body.find('#id_almacen').val(),
							almacen: body.find('#almacen').val(),
							descripcion: body.find('#almacen_descripcion').val()
						},
						success: function (result) {
							table_almacen.ajax.reload();
							modal.modal('hide');
							notify(result.type, result.icon, result.message);
						},
						error: function (error) {
							error = error.responseJSON;
							(error.area)?
							body.find('#almacen').closest('div').addClass('has-error').find('.help-block').text(error.almacen[0]):
							body.find("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
							(error.descripcion)?
							body.find("#almacen_descripcion").closest('div').addClass('has-error').find('.help-block').text(error.descripcion[0]):
							body.find("#almacen_descripcion").closest('div').removeClass('has-error').find('.help-block').text('');
						}
					})
				});
				modal.modal('show');
			});


		});
	</script>
	@endsection