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
			<small>editar funcionarios</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-warning box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Datos del personales funcionario</h3>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" action="{{ url('update_funcionario') }}">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $funcionario->id }}" name="id">
						<div class="box-body">
							<div class="form-group {{ $errors->has('ci')?'has-error':'' }}">
								<label class="control-label">CI <i class="required">*</i></label>
								<input type="text" value="{{ $funcionario->ci }}" name="ci" class="form-control" placeholder="Cedula de identidad">
								<span class="help-block">{{ $errors->first('ci') }}</span>
							</div>

							<div class="form-group {{ $errors->has('expedido')?'has-error':'' }}">
								<label class="control-label">Expedido <i class="required">*</i></label>
								<select class="form-control" name="expedido">
									<option value="">Elija una opcion</option>
									<option value="LP" {{ ($funcionario->expedido == 'LP')?'selected':'' }}>LA PAZ</option>
									<option value="OR" {{ ($funcionario->expedido == 'OR')?'selected':'' }}>ORURO</option>
									<option value="CB" {{ ($funcionario->expedido == 'CB')?'selected':'' }}>COCHABAMBA</option>
									<option value="PT" {{ ($funcionario->expedido == 'PT')?'selected':'' }}>POTOSI</option>
									<option value="SC" {{ ($funcionario->expedido == 'SC')?'selected':'' }}>SANTA CRUZ</option>
									<option value="TJ" {{ ($funcionario->expedido == 'TJ')?'selected':'' }}>TARIJA</option>
									<option value="BN" {{ ($funcionario->expedido == 'BN')?'selected':'' }}>BENI</option>
									<option value="PA" {{ ($funcionario->expedido == 'PA')?'selected':'' }}>PANDO</option>
									<option value="CH" {{ ($funcionario->expedido == 'CH')?'selected':'' }}>CHUQUISACA</option>
								</select>
								<span class="help-block">{{ $errors->first('expedido') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('nombre')?'has-error':'' }}">
								<label class="control-label">Nombre <i class="required">*</i></label>
								<input type="text" value="{{ $funcionario->nombre }}" name="nombre" class="form-control" placeholder="Ej. Selem">
								<span class="help-block">{{ $errors->first('nombre') }}</span>
							</div>

							<div class="form-group {{ $errors->has('apellidoPaterno')?'has-error':'' }}">
								<label class="control-label">Apellido paterno <i class="required">*</i></label>
								<input type="text" value="{{ $funcionario->ap_paterno }}" name="apellidoPaterno" class="form-control" placeholder="Ej. Luna">
								<span class="help-block">{{ $errors->first('apellidoPaterno') }}</span>
							</div>

							<div class="form-group {{ $errors->has('apellidoMaterno')?'has-error':'' }}">
								<label class="control-label">Apellido materno <i class="required">*</i></label>
								<input type="text" value="{{ $funcionario->ap_materno }}" name="apellidoMaterno" class="form-control">
								<span class="help-block">{{ $errors->first('apellidoMaterno') }}</span>
							</div>

							<div class="form-group {{ $errors->has('fechaNacimiento')?'has-error':'' }}">
								<label>Fecha nacimiento: <i class="required">*</i></label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" value="{{ $funcionario->fec_nac }}" class="form-control pull-right" id="datepicker" name="fechaNacimiento">
								</div>
								<span class="help-block">{{ $errors->first('fechaNacimiento') }}</span>
							</div>

							<div class="form-group {{ $errors->has('genero')?'has-error':'' }}">
								<label class="control-label">Genero <i class="required">*</i></label>
								<select class="form-control" name="genero">
									<option value="">Elija una opcion</option>
									<option value="MASCULINO" {{ ($funcionario->genero == 'MASCULINO')?'selected':'' }}>MASCULINO</option>
									<option value="FEMENINO" {{ ($funcionario->genero == 'FEMENINO')?'selected':'' }}>FEMENINO</option>
								</select>
								<span class="help-block">{{ $errors->first('genero') }}</span>
							</div>  
						</div>
					</div>

					<div class="box box-warning box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Direccion donde vive el funcionario</h3>
						</div>
						<div class="box-body">
							<div class="form-group {{ $errors->has('departamento')?'has-error':'' }}">
								<label class="control-label">Departamento <i class="required">*</i></label>
								<select class="form-control" name="departamento">
									<option value="">Elija una opcion</option>
									<option value="LA PAZ" {{ ($funcionario->departamento == 'LA PAZ')?'selected':'' }}>LA PAZ</option>
									<option value="ORURO" {{ ($funcionario->departamento == 'ORURO')?'selected':'' }}>ORURO</option>
									<option value="COCHABAMBA" {{ ($funcionario->departamento == 'COCHABAMBA')?'selected':'' }}>COCHABAMBA</option>
									<option value="POTOSI" {{ ($funcionario->departamento == 'POTOSI')?'selected':'' }}>POTOSI</option>
									<option value="SANTA CRUZ" {{ ($funcionario->departamento == 'SANTA CRUZ')?'selected':'' }}>SANTA CRUZ</option>
									<option value="TARIJA" {{ ($funcionario->departamento == 'TARIJA')?'selected':'' }}>TARIJA</option>
									<option value="BENI" {{ ($funcionario->departamento == 'BENI')?'selected':'' }}>BENI</option>
									<option value="PANDO" {{ ($funcionario->departamento == 'PANDO')?'selected':'' }}>PANDO</option>
									<option value="CHUQUISACA" {{ ($funcionario->departamento == 'CHUQUISACA')?'selected':'' }}>CHUQUISACA</option>
								</select>
								<span class="help-block">{{ $errors->first('departamento') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('ciudad')?'has-error':'' }}">
								<label class="control-label">Ciudad <i class="required">*</i></label>
								<input type="text" value="{{ $funcionario->ciudad }}" name="ciudad" class="form-control" placeholder="Ej. El Alto">
								<span class="help-block">{{ $errors->first('ciudad') }}</span>
							</div>

							<div class="form-group">
								<label class="control-label">Zona</label>
								<input type="text" value="{{ $funcionario->zona }}" name="zona" class="form-control" placeholder="Ej. Satelite">
							</div>
							<div class="form-group">
								<label class="control-label">Calle </label>
								<input type="text" value="{{ $funcionario->calle }}" name="calle" class="form-control">
							</div>

							<div class="form-group">
								<label>Nro. Puerta:</label>
								<input type="number" value="{{ $funcionario->nro_puerta }}" class="form-control" name="nro_puerta">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="box box-warning box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Datos generales del funcionario</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="control-label">Nro. Telefono</label>
								<input type="number" value="{{ $funcionario->telefono }}" name="telefono" class="form-control" placeholder="Ej. El Alto">
							</div>
							
							<div class="form-group {{ $errors->has('celular')?'has-error':'' }}">
								<label class="control-label">Nro. Celular <i class="required">*</i></label>
								<input type="number" value="{{ old('celular') }}" name="celular" class="form-control" placeholder="Ej. El Alto">
								<span class="help-block">{{ $errors->first('celular') }}</span>
							</div>

							<div class="form-group">
								<label class="control-label">Email</label>
								<input type="email" value="{{ $funcionario->email }}" name="email" class="form-control" placeholder="Ej. selen@gmail.com">
							</div>

							<div class="form-group {{ $errors->has('sucursal')?'has-error':'' }}">
								<label class="control-label">Sucursal <i class="required">*</i></label>
								<select id="sucursal" class="form-control" name="sucursal">
									<option value="">Elija una opcion</option>
									@foreach ($sucursal as $item)
										<option value="{{ $item->id }}" {{ ($funcionario->sucursal ==  $item->id )?'selected':'' }}>{{ $item->nombre }}</option>
									@endforeach
								</select>
								<span class="help-block">{{ $errors->first('sucursal') }}</span>
							</div>

							<div class="form-group {{ $errors->has('area')?'has-error':'' }}">
								<label class="control-label">Area <i class="required">*</i></label>
								<select class="form-control select2" style="width: 100%;" name="area">
								</select>
								<span class="help-block">{{ $errors->first('area') }}</span>
							</div>

							<div class="form-group {{ $errors->has('cargo')?'has-error':'' }}">
								<label class="control-label">Cargo <i class="required">*</i></label>
								<select class="form-control" name="cargo">
									<option value="">Elija una opcion</option>
									@foreach ($cargo as $item)
										<option value="{{ $item->id }}" {{ ($funcionario->cargo == $item->id)?'selected':'' }}>{{ $item->cargo }}</option>
									@endforeach
								</select>
								<span class="help-block">{{ $errors->first('cargo') }}</span>
							</div>

							<div class="form-group {{ $errors->has('foto')?'has-error':'' }} col-md-5">
								<label class="control-label">Foto <i class="required">*</i></label>
								<input type="file" name="foto">
								<p class="help-block">Foto del funcionario (png,jpg)</p>
								<span class="help-block">{{ $errors->first('foto') }}</span>
							</div>

							<div class="form-group col-md-7">
								<img src="{{ URL::asset('storage/'.$funcionario->foto) }}" width="150rem" height="150rem" class="pull-right">
							</div>
						</div>
						<div class="box-footer">
							<button id="submit-btn" type="submit" class="btn btn-warning pull-right">ACTUALIZAR DATOS</button>
						</div>
					</div>
				</form>
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
		$.ajax({
				url: "{{ url('get_areas_select2') }}/"+{{ $funcionario->sucursal }},
				success:function(response){
					response.data.find(function(element) {
						if (element.id == {{ $funcionario->area }}) { element.selected = true} 
					});
					$('.select2').empty();
					$('.select2').select2({data: response.data});
				}
			});

		$('#datepicker').datepicker({
			autoclose: true,
			language: 'es',
			format: 'yyyy-mm-dd',
		});
		
		$( "#sucursal" ).change(function() {
			id_sucursal = $('#sucursal').val();
			$.ajax({
				url: "{{ url('get_areas_select2') }}/"+id_sucursal,
				success:function(response){
					$('.select2').empty();
					$('.select2').select2({data: response.data});
				}
			});
		});
	})

</script>
@endsection