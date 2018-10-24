@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>registro de usuarios</small>
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
						<h3 class="box-title">Datos del usuario</h3>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" action="{{ url('save_user') }}">
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
									<option value="CB" {{ (old('expedido') == 'OR')?'selected':'' }}>COCHABAMBA</option>
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
							<div class="form-group {{ $errors->has('email')?'has-error':'' }}">
								<label class="control-label">Email <i class="required">*</i></label>
								<input type="Email" value="{{ old('email') }}" name="email" class="form-control" placeholder="selem@gmail.com">
								<span class="help-block">{{ $errors->first('email') }}</span>
							</div>
							<div class="form-group {{ $errors->has('password')?'has-error':'' }}">
								<label class="control-label">Password <i class="required">*</i></label>
								<input type="Password" name="password" class="form-control" placeholder="********">
								<span class="help-block">{{ $errors->first('password') }}</span>
							</div>
							<div class="form-group {{ $errors->has('password_confirmation')?'has-error':'' }}">
								<label class="control-label">Confirmar</label>
								<input type="Password" name="password_confirmation" class="form-control" placeholder="********">
							</div>
							<div class="form-group {{ $errors->has('password')?'has-error':'' }}">
								<label class="control-label">Foto <i class="required">*</i></label>
								<input type="file" name="foto">
								<p class="help-block">Foto del usuario (png,jpg)</p>
							</div>
							
						</div>
						<div class="box-footer">
							<button id="submit-btn" type="submit" class="btn btn-primary">REGISTRAR</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection