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
			<small>creacion de equipos</small>
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

				<div class="box box-primary collapsed-box">
					<div class="box-header with-border">
						<h3 class="box-title">REGISTRO MASIVO VIA EXCEL</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="box-body">

								<div class="form-group">
									<label class="control-label">Categoria <i class="required">*</i></label>
									<select id="categoria" class="form-control" name="categoria">
										<option value="">Elija una opcion</option>
										@foreach ($categoria as $item)
										<option codigo="{{ $item->codigo }}" value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('sucursal') }}</span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Sucursal <i class="required">*</i></label>
									<select id="sucursal" class="form-control" name="sucursal">
										<option value="">Elija una opcion</option>
										@foreach ($sucursal as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('sucursal') }}</span>
								</div>

								<div class="form-group">
									<label class="control-label">Almacen <i class="required">*</i></label>
									<select class="form-control select2" style="width: 100%;" name="almacen" id="almacen">
									</select>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
                  <label for="exampleInputFile">Archivo excel</label>
                  <input type="file" id="exampleInputFile">
                </div>
								

							</div>
							<div class="box-footer">
								<button id="submit-btn" type="submit" class="btn btn-primary">INSERTAR TODO</button>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
				</div>

				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Creacion de equipos</h3>
					</div>
					<div class="box-body">
						<form id="form_equipo" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="box-body">

								<div class="form-group">
									<label class="control-label">Categoria <i class="required">*</i></label>
									<select id="categoria" class="form-control" name="categoria">
										<option value="">Elija una opcion</option>
										@foreach ($categoria as $item)
										<option codigo="{{ $item->codigo }}" value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('sucursal') }}</span>
								</div>

								<div class="form-group">
									<label class="control-label">Codigo SIAF <i class="required">*</i></label>
									<input id="codigo" name="codigo" readonly type="text" class="form-control">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Marca <i class="required">*</i></label>
									<input id="marca" name="marca" type="text" class="form-control" placeholder="DELL">
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Modelo <i class="required">*</i></label>
									<input id="modelo" name="modelo" type="text" class="form-control" placeholder="DELL INSPIRON">
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Procesador</label>
									<input id="procesador" name="procesador" type="text" class="form-control" placeholder="378378-ee3-00">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Serie</label>
									<input id="serie" name="serie" type="text" class="form-control" placeholder="i7 8000">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Descripcion</label>
									<input id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Descripcion del equipo">
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label>Fecha de ingreso: <i class="required">*</i></label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
									</div>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Sucursal <i class="required">*</i></label>
									<select id="sucursal" class="form-control" name="sucursal">
										<option value="">Elija una opcion</option>
										@foreach ($sucursal as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('sucursal') }}</span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Almacen <i class="required">*</i></label>
									<select class="form-control select2" style="width: 100%;" name="almacen" id="almacen">
									</select>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label>Observaciones</label>
									<textarea id="observacion" name="observacion" class="form-control" rows="3" placeholder="Detalle la obsevacion ..."></textarea>
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
						<h3 class="box-title">EQUIPOS REGISTRADOS EN EL SISTEMA</h3>
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
									<th>ALMACEN</th>S
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
<script src="{{ url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('template/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ url('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#datepicker').datepicker({
			autoclose: true,
			language: 'es',
			format: 'yyyy-mm-dd',
		});

		$( "#categoria" ).change(function() {
			id_categoria = $('#categoria').val();
			$.ajax({
				url: "{{ url('get_codigo_categoria') }}/"+id_categoria,
				success:function(response){
					$("#codigo").val(response.codigo);
				}
			});

		});

		$( "#sucursal" ).change(function() {
			id_sucursal = $('#sucursal').val();
			$.ajax({
				url: "{{ url('get_almacenes_select2') }}/"+id_sucursal,
				success:function(response){
					$('.select2').empty();
					$('.select2').select2({data: response.data});
				}
			});
		});

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
			"ajax": "{{ url('get_equipos') }}",
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
			{ "data": "almacen" }
			],
		});

		modal = $('#modal');
		$("#submit-btn").click(function(e) {
			e.preventDefault();
			modal.find('.modal').addClass("bs-example-modal-sm");
			modal.find('.modal-dialog').addClass("modal-sm");
			modal.find('h4').text('CREAR EQUIPO');
			body = modal.find('.modal-body');
			body.html('Esta seguro de crear el equipo..?');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{ url('save_equipo') }}',
					type: 'POST',
					data: new FormData($("#form_equipo")[0]),
					contentType: false,
					cache: false,
					processData: false,
					success: function (result) {
						notify(result.type, result.icon, result.message);
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#tiempo_vida_util").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#foto").closest('div').removeClass('has-error').find('.help-block').text('');
						table_equipos.ajax.reload();
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
// data: new FormData(body.find('#form_categoria_update'[0])),
$("#categoria-table").on('click', '.edit-categoria', function (e) {
	e.preventDefault();
	modal.find('.modal').removeClass("bs-example-modal-sm");
	modal.find('.modal-dialog').removeClass("modal-sm");
	modal.find('h4').text('EDITAR CATEGORIA');
	modal.find('.btn-default').text('Cancelar');
	modal.find('.btn-primary').text('Actualizar');
	id_categoria = $(this).closest('tr').attr('id');
	$.ajax({
		url: "{{ url('editar_categoria') }}/"+id_categoria,
		success:function(response){
			body = modal.find('.modal-body');
			body.html(response);
		}
	});
	modal.find('.btn-primary').off().on('click',function(e){
		e.preventDefault();
		$.ajax({
			url: '{{ url('update_categoria') }}',
			type: 'POST',
			data: new FormData($("#form_categoria_update")[0]),
			contentType: false,
			cache: false,
			processData: false,
			success: function (result) {
				notify(result.type, result.icon, result.message);
				table_categoria.ajax.reload();
				modal.modal('hide');
				$("#form_categoria_update")[0].reset();
			},
			error: function (error) {
				error = error.responseJSON;
				(error.categoria)?
				body.find('#categoria').closest('div').addClass('has-error').find('.help-block').text(error.categoria[0]):
				body.find("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
				(error.tiempo_vida_util)?
				body.find("#tiempo_vida_util").closest('div').addClass('has-error').find('.help-block').text(error.tiempo_vida_util[0]):
				body.find("#tiempo_vida_util").closest('div').removeClass('has-error').find('.help-block').text('');
			}
		})
	});
	modal.modal('show');
});

})
</script>
@endsection