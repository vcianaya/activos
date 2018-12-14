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

				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Creacion de equipos</h3>
					</div>
					<div class="box-body">
						<form id="form_equipo" method="post" enctype="multipart/form-data">
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
									<label class="control-label">FUNCIONARIO <i class="required">*</i></label>
									<select id="funcionario" class="form-control select_funcionario" name="funcionario">
										<option value="">Elija una opcion</option>
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
									<label>FECHA DE INGRESO: <i class="required">*</i></label>
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
									<textarea id="observacion" name="observacion" class="form-control" rows="3" placeholder="Detalle la obsevacion ..."></textarea>
								</div>
								

							</div>
							<div class="box-footer">
								<button id="submit-btn-equipo" type="submit" class="btn btn-primary">ASIGNAR</button>
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
			console.log(data);
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