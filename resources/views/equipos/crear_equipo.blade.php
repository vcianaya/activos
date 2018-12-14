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
						<h3 class="box-title">REGISTRO DE EQUIPOS MASIVO VIA EXCEL</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form id="carga_masiva" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="box-body">

								<div class="form-group">
									<label class="control-label">Categoria <i class="required">*</i></label>
									<select  class="form-control" id="id_categoria" name="id_categoria">
										<option value="">Elija una opcion</option>
										@foreach ($categoria as $item)
										<option codigo="{{ $item->codigo }}" value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block">{{ $errors->first('sucursal') }}</span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Sucursal <i class="required">*</i></label>
									<select class="form-control" id="sucursal_m" name="id_sucursal">
										<option value="">Elija una opcion</option>
										@foreach ($sucursal as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">Almacen <i class="required">*</i></label>
									<select class="form-control select_almacen" id="id_almacen" name="id_almacen" style="width: 100%;">
									</select>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label for="exampleInputFile">Archivo excel</label>
									<input type="file" id="file_excel" name="file_excel">
								</div>
								

							</div>
							<div class="box-footer">
								<button id="submit-btn-excel" type="submit" class="btn btn-primary">INSERTAR TODO</button>
                <a href="{{ url('descargar_formato') }}" class="btn btn-info pull-right"><i class="fa fa-file-excel-o"></i> DESCARGAR EXCEL</a>
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
									<span style="color:red" class="help-block" id="err-datepicker"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">Sucursal <i class="required">*</i></label>
									<select id="sucursal" class="form-control" name="sucursal">
										<option value="">Elija una opcion</option>
										@foreach ($sucursal as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
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
								<button id="submit-btn-equipo" type="submit" class="btn btn-primary">CREAR</button>
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
									<th>ALMACEN</th>S
									<th>ACCION</th>S
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
		// CARGAS MASIVAS
		$( "#sucursal_m" ).change(function() {
			id_sucursal = $('#sucursal_m').val();
			$.ajax({
				url: "{{ url('get_almacenes_select2') }}/"+id_sucursal,
				success:function(response){
					$('.select_almacen').empty();
					$('.select_almacen').select2({data: response.data});
				}
			});
		});

			$("#submit-btn-excel").click(function(e) {
			e.preventDefault();
			modal.find('.modal').addClass("bs-example-modal-sm");
			modal.find('.modal-dialog').addClass("modal-sm");
			modal.find('h4').text('CARGA MASIVA');
			body = modal.find('.modal-body');
			body.html('Esta seguro de insertar los equipos..?');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{ url('registro_masivo_equipos') }}',
					type: 'POST',
					data: new FormData($("#carga_masiva")[0]),
					contentType: false,
					cache: false,
					processData: false,
					success: function (result) {
						notify(result.type, result.icon, result.message);
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#marca").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#modelo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#datepicker").closest('div').removeClass('has-error');
						$('#err-datepicker').text('');
						$("#sucursal").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
						table_equipos.ajax.reload();
						modal.modal('hide');
						$('#carga_masiva')[0].reset();
					},
					error: function (error) {
						error = error.responseJSON;
						(error.id_categoria)?
						$("#id_categoria").closest('div').addClass('has-error').find('.help-block').text(error.id_categoria[0]):
						$("#id_categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.id_sucursal)?
						$("#id_sucursal").closest('div').addClass('has-error').find('.help-block').text(error.id_sucursal[0]):
						$("#id_sucursal").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.id_almacen)?
						$("#id_almacen").closest('div').addClass('has-error').find('.help-block').text(error.id_almacen[0]):
						$("#id_almacen").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.modelo)?
						$("#file_excel").closest('div').addClass('has-error').find('.help-block').text(error.file_excel[0]):
						$("#file_excel").closest('div').removeClass('has-error').find('.help-block').text('');
					}
				})
			});
			modal.modal('show');
		});


		// REGISTRO EQUIPO
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
			{ "data": "almacen" },
			{ "data": "accion" }
			],
		});

		modal = $('#modal');
		//INSERTAR EQUIPO
		$("#submit-btn-equipo").click(function(e) {
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
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#marca").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#modelo").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#datepicker").closest('div').removeClass('has-error');
						$('#err-datepicker').text('');
						$("#sucursal").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
						table_equipos.ajax.reload();
						modal.modal('hide');
						$('#form_equipo')[0].reset();
					},
					error: function (error) {
						error = error.responseJSON;
						(error.categoria)?
						$("#categoria").closest('div').addClass('has-error').find('.help-block').text(error.categoria[0]):
						$("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.codigo)?
						$("#codigo").closest('div').addClass('has-error').find('.help-block').text(error.codigo[0]):
						$("#codigo").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.marca)?
						$("#marca").closest('div').addClass('has-error').find('.help-block').text(error.marca[0]):
						$("#tiempo_vida_util").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.modelo)?
						$("#modelo").closest('div').addClass('has-error').find('.help-block').text(error.modelo[0]):
						$("#modelo").closest('div').removeClass('has-error').find('.help-block').text('');
						if(error.datepicker){
							$("#datepicker").closest('div').addClass('has-error');
							$('#err-datepicker').text('El campo fecha de ingreso es requerido');
						}else{
							$("#datepicker").closest('div').removeClass('has-error');
							$('#err-datepicker').text('');
						}
						(error.sucursal)?
						$("#sucursal").closest('div').addClass('has-error').find('.help-block').text(error.sucursal[0]):
						$("#sucursal").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.almacen)?
						$("#almacen").closest('div').addClass('has-error').find('.help-block').text(error.almacen[0]):
						$("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
					}
				})
			});
			modal.modal('show');
		});
		table_equipos.on('click', '.edit-equipo', function (e) {
			e.preventDefault();
			modal.find('.modal').removeClass("bs-example-modal-sm");
			modal.find('.modal-dialog').removeClass("modal-sm");
			modal.find('h4').text('EDITAR EQUIPO');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Actualizar');
			id_equipo = $(this).closest('tr').attr('id');
			$.ajax({
				url: "{{ url('editar_equipo') }}/"+id_equipo,
				success:function(response){
					body = modal.find('.modal-body');
					body.html(response);
				}
			});
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();
				$.ajax({
					url: '{{ url('update_equipo') }}',
					type: 'POST',
					data: new FormData($("#form_equipo_update")[0]),
					contentType: false,
					cache: false,
					processData: false,
					success: function (result) {
						notify(result.type, result.icon, result.message);
						table_equipos.ajax.reload();
						modal.modal('hide');
						$("#form_equipo_update")[0].reset();
					},
					error: function (error) {
						error = error.responseJSON;
						(error.categoria)?
						body.find('#categoria').closest('div').addClass('has-error').find('.help-block').text(error.categoria[0]):
						body.find("#categoria").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.marca)?
						body.find('#marca').closest('div').addClass('has-error').find('.help-block').text(error.marca[0]):
						body.find("#marca").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.modelo)?
						body.find('#modelo').closest('div').addClass('has-error').find('.help-block').text(error.modelo[0]):
						body.find("#modelo").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.almacen)?
						body.find('#almacen').closest('div').addClass('has-error').find('.help-block').text(error.almacen[0]):
						body.find("#almacen").closest('div').removeClass('has-error').find('.help-block').text('');
						if(error.datepicker){
							body.find('#datepicker').closest('div').addClass('has-error');
							body.find('#err-datepicker').text('El campo fecha de ingreso es requerido');
						}else{
							body.find("#datepicker").closest('div').removeClass('has-error');
							body.find('#err-datepicker').text('');
						}
					}
				})
			});
			modal.modal('show');
		});
		//MODAL UPDATE
})
</script>
@endsection