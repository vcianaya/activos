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
			<small>asignación de activos</small>
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
						<h3 class="box-title">ASIGNAR ACTIVOS</h3>
					</div>
					<div class="box-body">
						<form id="form_activos" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="box-body">
								<div class="form-group">
									<label class="control-label">SUCURSAL <i class="required">*</i></label>
									<select id="sucursal" class="form-control select2" name="sucursal">
										<option value="">Elija una opcion</option>
										@foreach ($sucursal as $item)
										<option value="{{ $item->id }}">{{ $item->nombre.' - '.$item->departamento }}</option>
										@endforeach
									</select>
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label class="control-label">ALMACEN <i class="required">*</i></label>
									<select id="almacen" class="form-control select_almacen" name="almacen">
										<option value="">Elija una opcion</option>
									</select>
									<span class="help-block"></span>
								</div>
								
								<div class="form-group">
									<label class="control-label">FUNCIONARIO <i class="required">*</i></label>
									<select id="funcionario" class="form-control select_funcionario" name="funcionario">
										<option value="">Elija una opcion</option>
									</select>
									<span class="help-block"></span>
								</div>

								<div class="form-group">
									<label>FECHA DE ASIGNACIÓN: <i class="required">*</i></label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
									</div>
									<span style="color:red" class="help-block" id="err-datepicker"></span>
								</div>
								
								<div class="form-group">
									<label>DETALLE ASIGNACION</label>
									<textarea id="detalle_asignacion" name="detalle_asignacion" class="form-control" rows="3" placeholder="Detalle la obsevacion ..."></textarea>
									<span class="help-block"></span>
								</div>
								
								<input id="equipos" type="hidden" name="equipos[]">

							</div>
							<div class="box-footer">
								<button id="submit-activos" type="submit" class="btn btn-primary">ASIGNAR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-info" id="container-table">
				</div>

				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">EQUIPOS ASIGNADOS</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="asignados-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th>CATEGORIA</th>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>MODELO</th>
									<th>PROCESADOR</th>
									<th>FECHA INGRESO</th>
									<th>DESCRIPCION</th>
									<th>QUITAR</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot>
								<tr>
									<th>CATEGORIA</th>
									<th width="60px">Codigo SIAF</th>
									<th>MARCA</th>
									<th>MODELO</th>
									<th>PROCESADOR</th>
									<th>FECHA INGRESO</th>
									<th>DESCRIPCION</th>
									<th>QUITAR</th>
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
		//TALBA ASIGNADOS
		equipos = [];
		asignados_table = $('#asignados-table').DataTable({});
		asignados_table.on('click', '.quitar_activo', function (e) {
			e.preventDefault();
			_fila = $(this).closest('tr');
			data = asignados_table.row($(this).parents('tr')).data();
			asignados_table.row($(this).parents('tr')).remove().draw(false);
			table_equipos.row.add([
				data[0],
				data[1],
				data[2],
				data[3],
				data[4],
				data[5],
				data[6],
				'<button type="button" class="btn btn-block btn-primary btn-xs asignar_activo">Asignar</button>'
				]).draw( false );
			 equipos.splice(equipos.indexOf(data.DT_RowId), 1);
			 $('#equipos').val(equipos);
		});
		//end tabla asignados
		//ENVIAR DATOS
		$("#submit-activos").click(function(e) {
			e.preventDefault();
			modal.find('.modal').addClass("bs-example-modal-sm");
			modal.find('.modal-dialog').addClass("modal-sm");
			modal.find('h4').text('ASIGNAR ACTIVOS');
			body = modal.find('.modal-body');
			body.html('Esta seguro de asignar los activos..?');
			modal.find('.btn-default').text('Cancelar');
			modal.find('.btn-primary').text('Aceptar');
			modal.find('.btn-primary').off().on('click',function(e){
				e.preventDefault();

			if (equipos.length>0) {
				$.ajax({
					url: '{{ url('save_activos') }}',
					type: 'POST',
					data: new FormData($("#form_activos")[0]),
					contentType: false,
					cache: false,
					processData: false,
					success: function (result) {
						notify(result.type, result.icon, result.message);
						$("#detalle_asignacion").closest('div').removeClass('has-error').find('.help-block').text('');
						$("#funcionario").closest('div').removeClass('has-error').find('.help-block').text('');
						$('#err-datepicker').text('');
						modal.modal('hide');
						asignados_table.clear().draw();
						$('#form_activos')[0].reset();
						equipos = [];
					},
					error: function (error) {
						error = error.responseJSON;
						(error.detalle_asignacion)?
						$("#detalle_asignacion").closest('div').addClass('has-error').find('.help-block').text(error.detalle_asignacion[0]):
						$("#detalle_asignacion").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.funcionario)?
						$("#funcionario").closest('div').addClass('has-error').find('.help-block').text(error.funcionario[0]):
						$("#funcionario").closest('div').removeClass('has-error').find('.help-block').text('');
						(error.datepicker)?
						$("#err-datepicker").closest('div').addClass('has-error').find('.help-block').text('El campo fecha de ingreso es requerido'):
						$("#datepicker").closest('div').removeClass('has-error').find('.help-block').text('');
					}
				})
			}else{
				modal.modal('hide');
				notify('danger', 'fa fa-frown-o', 'No tiene activos para asignar');
			}
				


			});
			modal.modal('show');
		});
		//END ENVIAR DATOS
		$('.select2').select2();
		$( "#sucursal" ).change(function() {
			id_sucursal = $('#sucursal').val();
			$.ajax({
				url: "{{ url('get_funcionarios') }}/"+id_sucursal,
				success:function(response){
					$('.select_funcionario').empty();
					$('.select_funcionario').select2({data: response.data});
				}
			});

			$.ajax({
				url: "{{ url('get_almacen') }}/"+id_sucursal,
				success:function(response){
					$('.select_almacen').empty();
					$('.select_almacen').select2({data: response.data});
				}
			});

		});

		$( "#almacen" ).on('select2:select', function (e) {
			var data = e.params.data;
			if (data.id != ' ') {
				$.ajax({
					url: "{{ url('get_equipos_table') }}/"+data.id,
					success:function(response){
						$("#container-table").html(response);
					}
				});
			}
		});
		// REGISTRO EQUIPO
		$('#datepicker').datepicker({
			autoclose: true,
			language: 'es',
			format: 'yyyy-mm-dd',
		});
	});
</script>
@endsection