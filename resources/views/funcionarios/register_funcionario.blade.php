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
			<small>registro de funcionarios</small>
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
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Datos del personales funcionario</h3>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" action="{{ url('save_funcionario') }}">
						{{ csrf_field() }}
						<div class="box-body">
							<div class="form-group {{ $errors->has('ci')?'has-error':'' }}">
								<label class="control-label">CI <i class="required">*</i></label>
								<input type="text" value="{{ old('ci') }}" name="ci" class="form-control" placeholder="Cedula de identidad">
								<span class="help-block">{{ $errors->first('ci') }}</span>
							</div>

							<div class="form-group {{ $errors->has('expedido')?'has-error':'' }}">
								<label class="control-label">Expedido <i class="required">*</i></label>
								<select class="form-control" name="expedido">
									<option value="">Elija una opcion</option>
									<option value="LP" {{ (old('expedido') == 'LP')?'selected':'' }}>LA PAZ</option>
									<option value="OR" {{ (old('expedido') == 'OR')?'selected':'' }}>ORURO</option>
									<option value="CB" {{ (old('expedido') == 'CB')?'selected':'' }}>COCHABAMBA</option>
									<option value="PT" {{ (old('expedido') == 'PT')?'selected':'' }}>POTOSI</option>
									<option value="SC" {{ (old('expedido') == 'SC')?'selected':'' }}>SANTA CRUZ</option>
									<option value="TJ" {{ (old('expedido') == 'TJ')?'selected':'' }}>TARIJA</option>
									<option value="BN" {{ (old('expedido') == 'BN')?'selected':'' }}>BENI</option>
									<option value="PA" {{ (old('expedido') == 'PA')?'selected':'' }}>PANDO</option>
									<option value="CH" {{ (old('expedido') == 'CH')?'selected':'' }}>CHUQUISACA</option>
								</select>
								<span class="help-block">{{ $errors->first('expedido') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('nombre')?'has-error':'' }}">
								<label class="control-label">Nombre <i class="required">*</i></label>
								<input type="text" value="{{ old('nombre') }}" name="nombre" class="form-control" placeholder="Ej. Selem">
								<span class="help-block">{{ $errors->first('nombre') }}</span>
							</div>

							<div class="form-group {{ $errors->has('apellidoPaterno')?'has-error':'' }}">
								<label class="control-label">Apellido paterno <i class="required">*</i></label>
								<input type="text" value="{{ old('apellidoPaterno') }}" name="apellidoPaterno" class="form-control" placeholder="Ej. Luna">
								<span class="help-block">{{ $errors->first('apellidoPaterno') }}</span>
							</div>

							<div class="form-group {{ $errors->has('apellidoMaterno')?'has-error':'' }}">
								<label class="control-label">Apellido materno <i class="required">*</i></label>
								<input type="text" value="{{ old('apellidoMaterno') }}" name="apellidoMaterno" class="form-control">
								<span class="help-block">{{ $errors->first('apellidoMaterno') }}</span>
							</div>

							<div class="form-group {{ $errors->has('fechaNacimiento')?'has-error':'' }}">
								<label>Fecha nacimiento: <i class="required">*</i></label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker" name="fechaNacimiento">
								</div>
								<span class="help-block">{{ $errors->first('fechaNacimiento') }}</span>
							</div>

							<div class="form-group {{ $errors->has('genero')?'has-error':'' }}">
								<label class="control-label">Genero <i class="required">*</i></label>
								<select class="form-control" name="genero">
									<option value="">Elija una opcion</option>
									<option value="LP" {{ (old('genero') == 'MASCULINO')?'selected':'' }}>MASCULINO</option>
									<option value="OR" {{ (old('genero') == 'FEMENINO')?'selected':'' }}>FEMENINO</option>
								</select>
								<span class="help-block">{{ $errors->first('genero') }}</span>
							</div>	
						</div>
					</div>

					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Direccion donde vive el funcionario</h3>
						</div>
						<div class="box-body">
							<div class="form-group {{ $errors->has('departamento')?'has-error':'' }}">
								<label class="control-label">Departamento <i class="required">*</i></label>
								<select class="form-control" name="departamento">
									<option value="">Elija una opcion</option>
									<option value="LP" {{ (old('departamento') == 'LA PAZ')?'selected':'' }}>LA PAZ</option>
									<option value="OR" {{ (old('departamento') == 'ORURO')?'selected':'' }}>ORURO</option>
									<option value="CB" {{ (old('departamento') == 'COCHABAMBA')?'selected':'' }}>COCHABAMBA</option>
									<option value="PT" {{ (old('departamento') == 'POTOSI')?'selected':'' }}>POTOSI</option>
									<option value="SC" {{ (old('departamento') == 'SANTA')?'selected':'' }}>SANTA CRUZ</option>
									<option value="TJ" {{ (old('departamento') == 'TARIJA')?'selected':'' }}>TARIJA</option>
									<option value="BN" {{ (old('departamento') == 'BENI')?'selected':'' }}>BENI</option>
									<option value="PA" {{ (old('departamento') == 'PANDO')?'selected':'' }}>PANDO</option>
									<option value="CH" {{ (old('departamento') == 'CHUQUISACA')?'selected':'' }}>CHUQUISACA</option>
								</select>
								<span class="help-block">{{ $errors->first('departamento') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('ciudad')?'has-error':'' }}">
								<label class="control-label">Ciudad <i class="required">*</i></label>
								<input type="text" value="{{ old('ciudad') }}" name="ciudad" class="form-control" placeholder="Ej. El Alto">
								<span class="help-block">{{ $errors->first('ciudad') }}</span>
							</div>

							<div class="form-group">
								<label class="control-label">Zona</label>
								<input type="text" value="{{ old('zona') }}" name="zona" class="form-control" placeholder="Ej. Satelite">
							</div>
							<div class="form-group">
								<label class="control-label">Calle </label>
								<input type="text" value="{{ old('calle') }}" name="calle" class="form-control">
							</div>

							<div class="form-group">
								<label>Nro. Puerta:</label>
								<input type="number" class="form-control" name="nro_puerta">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Datos generales del funcionario</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="control-label">Nro. Telefono</label>
								<input type="number" value="{{ old('telefono') }}" name="telefono" class="form-control" placeholder="Ej. El Alto">
							</div>
							
							<div class="form-group {{ $errors->has('celular')?'has-error':'' }}">
								<label class="control-label">Nro. Celular <i class="required">*</i></label>
								<input type="number" value="{{ old('celular') }}" name="celular" class="form-control" placeholder="Ej. El Alto">
								<span class="help-block">{{ $errors->first('celular') }}</span>
							</div>

							<div class="form-group">
								<label class="control-label">Email</label>
								<input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Ej. selen@gmail.com">
							</div>

							<div class="form-group {{ $errors->has('sucursal')?'has-error':'' }}">
								<label class="control-label">Sucursal <i class="required">*</i></label>
								<select id="sucursal" class="form-control" name="sucursal">
									<option value="">Elija una opcion</option>
									@foreach ($sucursal as $item)
										<option value="{{ $item->id }}" {{ (old('sucursal') ==  $item->id )?'selected':'' }}>{{ $item->nombre }}</option>
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
										<option value="{{ $item->id }}">{{ $item->cargo }}</option>
									@endforeach
								</select>
								<span class="help-block">{{ $errors->first('cargo') }}</span>
							</div>

							<div class="form-group {{ $errors->has('foto')?'has-error':'' }}">
								<label class="control-label">Foto <i class="required">*</i></label>
								<input type="file" name="foto">
								<p class="help-block">Foto del funcionario (png,jpg)</p>
								<span class="help-block">{{ $errors->first('foto') }}</span>
							</div>
						</div>
						<div class="box-footer">
							<button id="submit-btn" type="submit" class="btn btn-primary pull-right">REGISTRAR</button>
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
					console.log(response.data);
					$('.select2').empty();
					$('.select2').select2({data: response.data});
				}
			});
		});
	})

</script>
@endsection