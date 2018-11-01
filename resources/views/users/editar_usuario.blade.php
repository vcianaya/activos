@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>Editar datos de usuarios</small>
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
				<div class="box box-warning box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Datos del usuario</h3>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" action="{{ url('update_user') }}">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $user->id }}" name="id">
						<div class="box-body">
							<div class="form-group {{ $errors->has('ci')?'has-error':'' }}">
								<label class="control-label">CI <i class="required">*</i></label>
								<input type="text" value="{{ $user->ci }}" name="ci" class="form-control" placeholder="Cedula de identidad">
								<span class="help-block">{{ $errors->first('ci') }}</span>
							</div>

							<div class="form-group {{ $errors->has('expedido')?'has-error':'' }}">
								<label class="control-label">Expedido <i class="required">*</i></label>
								<select class="form-control" name="expedido">
									<option value="">Elija una opcion</option>
									<option value="LP" {{ ($user->expedido == 'LP')?'selected':'' }}>LA PAZ</option>
									<option value="OR" {{ ($user->expedido == 'OR')?'selected':'' }}>ORURO</option>
									<option value="CB" {{ ($user->expedido == 'CB')?'selected':'' }}>COCHABAMBA</option>
									<option value="PT" {{ ($user->expedido == 'PT')?'selected':'' }}>POTOSI</option>
									<option value="SC" {{ ($user->expedido == 'SC')?'selected':'' }}>SANTA CRUZ</option>
									<option value="TJ" {{ ($user->expedido == 'TJ')?'selected':'' }}>TARIJA</option>
									<option value="BN" {{ ($user->expedido == 'BN')?'selected':'' }}>BENI</option>
									<option value="PA" {{ ($user->expedido == 'PA')?'selected':'' }}>PANDO</option>
									<option value="CH" {{ ($user->expedido == 'CH')?'selected':'' }}>CHUQUISACA</option>
								</select>
								<span class="help-block">{{ $errors->first('expedido') }}</span>
							</div>
							
							<div class="form-group {{ $errors->has('nombre')?'has-error':'' }}">
								<label class="control-label">Nombre <i class="required">*</i></label>
								<input type="text" value="{{ $user->nombre }}" name="nombre" class="form-control" placeholder="Ej. Selem">
								<span class="help-block">{{ $errors->first('nombre') }}</span>
							</div>
							<div class="form-group {{ $errors->has('apellidoPaterno')?'has-error':'' }}">
								<label class="control-label">Apellido paterno <i class="required">*</i></label>
								<input type="text" value="{{ $user->ap_paterno }}" name="apellidoPaterno" class="form-control" placeholder="Ej. Luna">
								<span class="help-block">{{ $errors->first('apellidoPaterno') }}</span>
							</div>
							<div class="form-group {{ $errors->has('apellidoMaterno')?'has-error':'' }}">
								<label class="control-label">Apellido materno <i class="required">*</i></label>
								<input type="text" value="{{ $user->ap_materno }}" name="apellidoMaterno" class="form-control">
								<span class="help-block">{{ $errors->first('apellidoMaterno') }}</span>
							</div>
							<div class="form-group {{ $errors->has('email')?'has-error':'' }}">
								<label class="control-label">Email <i class="required">*</i></label>
								<input type="Email" value="{{ $user->email }}" name="email" class="form-control" placeholder="selem@gmail.com">
								<span class="help-block">{{ $errors->first('email') }}</span>
							</div>
							<div class="form-group {{ $errors->has('password')?'has-error':'' }}">
								<label class="control-label">Password <i class="required">*</i></label>
								<input type="Password" name="password" class="form-control" placeholder="********">
								<span class="help-block">{{ $errors->first('password') }}</span>
							</div>
							<div class="form-group {{ $errors->has('password')?'has-error':'' }} col-md-5">
								<label class="control-label">Foto <i class="required">*</i></label>
								<input type="file" name="foto">
								<p class="help-block">Foto del usuario (png,jpg)</p>
							</div>

							<div class="form-group {{ $errors->has('password')?'has-error':'' }} col-md-7">
								<img src="{{ URL::asset('storage/'.$user->foto) }}" width="150rem" height="150rem" class="pull-right">
							</div>

						</div>
						<div class="box-footer">
							<a href="{{ url('register_usuario') }}" type="submit" class="btn btn-default">CANCELAR</a>
							<button id="submit-btn" type="submit" class="btn btn-warning pull-right">ACTUALIZAR</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-md-8">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Usuarios Registrados</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="users-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th>CI</th>
									<th>Usuario</th>
									<th>Email</th>
									<th>Foto</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $item)
								<tr class="{{ ($item->estado == 0)?'danger':'' }}">
									<td>{{ $item->expedido.' '.$item->ci }}</td>
									<td>{{ $item->nombre.' '.$item->ap_paterno }}</td>
									<td>{{ $item->email }}</td>
									<td>
										@if ($item->foto)
										<img src="{{ URL::asset('storage/'.$item->foto) }}" width="100rem"   height="100rem">
										@endif
									</td>
									<td>
										<div class="btn-group-vertical">
											<a type="button" class="btn btn-warning btn-sm" href="{{ url('editar_usuario/'.$item->id) }}">Editar</a>
											@if ($item->estado == 1)
												<a type="button" class="btn btn-danger btn-sm" href="{{ url('delete_user/'.$item->id) }}">Eliminar</a>
											@else
												<a type="button" class="btn btn-success btn-sm" href="{{ url('restore_user/'.$item->id) }}">Restaurar</a>
											@endif
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>CI</th>
									<th>Usuario</th>
									<th>Email</th>
									<th>Foto</th>
									<th>Acción</th>
								</tr>
							</tfoot>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('js')
<script type="text/javascript">

	$(document).ready(function() {
		$('#users-table').DataTable({
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2,3,4],
				"className": "text-center",
			},],
		});
	})

</script>
@endsection