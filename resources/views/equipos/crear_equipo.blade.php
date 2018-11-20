@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>creacion de categorias y sequipos computacionales</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Creacion de categorias</h3>
					</div>
					<div class="box-body">
						<form id="form_categoria" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="box-body">
								<div class="form-group">
									<label class="control-label">Codigo <i class="required">*</i></label>
									<input id="codigo" name="codigo" type="text" class="form-control" placeholder="PC-XA-AB">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Categoria <i class="required">*</i></label>
									<input id="categoria" name="categoria" type="text" class="form-control" placeholder="EQUIPO DE ESCRITORIO">
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Tiempo de vida util (Meses) <i class="required">*</i></label>
									<input id="tiempo_vida_util" name="tiempo_vida_util" type="number" class="form-control" placeholder="23">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Foto <i class="required">*</i></label>
									<input id="foto" name="foto" type="file">
									<p>Foto de la sucursal (png,jpg)</p>
									<span class="help-block"></span>
								</div>

							</div>
							<div class="box-footer">
								<button id="submit-btn" type="submit" class="btn btn-primary">CREAR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">LISTADO DE CATEGORIAS DISPONIBLES</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="categoria-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th width="60px">Codigo</th>
									<th>Categoria</th>
									<th>Vida util</th>
									<th>Total Equipos</th>
									<th>Foto</th>
									<th>Accion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Codigo</th>
									<th>Categoria</th>
									<th>Vida util</th>
									<th>Total Equipos</th>
									<th>Foto</th>
									<th>Accion</th>
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

			table_categoria = $('#categoria-table').DataTable({
				"processing": true,
				"aaSorting": [],
				"ajax": "{{ url('get_categorias/') }}",
				"language": {
					"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
				},
				'columnDefs': [
				{
					"targets": [0,1,2],
					"className": "text-center",
				},],
				"columns": [
				{ "data": "codigo" },
				{ "data": "nombre" },
				{ "data": "vida_util" },
				{ "data": "total_equipos" },
				{ "data": "foto" },
				{ "data": "accion" },
				],
			});
		modal = $('#modal');
		$("#submit-btn").click(function(e) {
			e.preventDefault();
			modal.find('.modal').addClass("bs-example-modal-sm");
			modal.find('.modal-dialog').addClass("modal-sm");
			modal.find('h4').text('CREAR CATEGORIA');
			modal.find('p').text('Esta seguro de crear la categoria ?');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{ url('save_categoria') }}',
					type: 'POST',
					data: new FormData($("#form_categoria")[0]),
					contentType: false,
					cache: false,
					processData: false,
					success: function (result) {
						notify(result.type, result.icon, result.message);
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#tiempo_vida_util").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#foto").closest('div').removeClass('has-error').find('.help-block').text('');
						// table_area.ajax.reload();
						modal.modal('hide');
						$('#form_categoria')[0].reset();
					},
					error: function (error) {
						error = error.responseJSON;
						(error.codigo)?
						$("#codigo").closest('div').addClass('has-error').find('.help-block').text(error.codigo[0]):
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.categoria)?
						$("#categoria").closest('div').addClass('has-error').find('.help-block').text(error.categoria[0]):
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.tiempo_vida_util)?
						$("#tiempo_vida_util").closest('div').addClass('has-error').find('.help-block').text(error.tiempo_vida_util[0]):
						$("#tiempo_vida_util").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.foto)?
						$("#foto").closest('div').addClass('has-error').find('.help-block').text(error.foto[0]):
						$("#foto").closest('div').removeClass('has-error').find('.help-block').text('');
					}
				})
			});
			modal.modal('show');
		});
	})
</script>
@endsection