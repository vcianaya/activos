@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>registro de sucursales</small>
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
						<h3 class="box-title">Datos de la Sucursal</h3>
					</div>
					<div class="box-body">
						<form role="form" method="post" enctype="multipart/form-data" action="{{ url('save_sucursal') }}">
							{{ csrf_field() }}
							<div class="box-body">
								<div class="form-group {{ $errors->has('nit')?'has-error':'' }}">
									<label class="control-label">NIT <i class="required">*</i></label>
									<input type="number" value="{{ old('nit') }}" name="nit" class="form-control" placeholder="75983475" required>
									<span class="help-block">{{ $errors->first('nit') }}</span>
								</div>

								<div class="form-group {{ $errors->has('nombre')?'has-error':'' }}">
									<label class="control-label">Nombre sucursal <i class="required">*</i></label>
									<input type="text" value="{{ old('nombre') }}" name="nombre" class="form-control" placeholder="Impuestos Nacionales El Alto" required>
									<span class="help-block">{{ $errors->first('nombre') }}</span>
								</div>

								<div class="form-group {{ $errors->has('departamento')?'has-error':'' }}">
									<label class="control-label">Departamento <i class="required">*</i></label>
									<select class="form-control" name="departamento">
										<option value="">Elija una opcion</option>
										<option value="LA PAZ" {{ (old('departamento') == 'LA PAZ')?'selected':'' }}>LA PAZ</option>
										<option value="ORURO" {{ (old('departamento') == 'ORURO')?'selected':'' }}>ORURO</option>
										<option value="COCHABAMBA" {{ (old('departamento') == 'COCHABAMBA')?'selected':'' }}>COCHABAMBA</option>
										<option value="POTOSI" {{ (old('departamento') == 'POTOSI')?'selected':'' }}>POTOSI</option>
										<option value="SANTA CRUZ" {{ (old('departamento') == 'SANTA CRUZ')?'selected':'' }}>SANTA CRUZ</option>
										<option value="TARIJA" {{ (old('departamento') == 'TARIJA')?'selected':'' }}>TARIJA</option>
										<option value="BENI" {{ (old('departamento') == 'BENI')?'selected':'' }}>BENI</option>
										<option value="PANDO" {{ (old('departamento') == 'PANDO')?'selected':'' }}>PANDO</option>
										<option value="CHUQUISACA" {{ (old('departamento') == 'CHUQUISACA')?'selected':'' }}>CHUQUISACA</option>
									</select>
									<span class="help-block">{{ $errors->first('departamento') }}</span>
								</div>
								
								<div class="form-group {{ $errors->has('ciudad')?'has-error':'' }}">
									<label class="control-label">Ciudad <i class="required">*</i></label>
									<input type="text" value="{{ old('ciudad') }}" name="ciudad" class="form-control" placeholder="Ej. El Alto" required>
									<span class="help-block">{{ $errors->first('ciudad') }}</span>
								</div>

								<div class="form-group {{ $errors->has('zona')?'has-error':'' }}">
									<label class="control-label">Zona</label>
									<input type="text" value="{{ old('zona') }}" name="zona" class="form-control" placeholder="Ej. Ferro Petrol">
									<span class="help-block">{{ $errors->first('zona') }}</span>
								</div>

								<div class="form-group {{ $errors->has('calle')?'has-error':'' }}">
									<label class="control-label">Calle</label>
									<input type="text" value="{{ old('calle') }}" name="calle" class="form-control" placeholder="Ej. Calle #1">
									<span class="help-block">{{ $errors->first('calle') }}</span>
								</div>
								
								<div class="form-group {{ $errors->has('num_puerta')?'has-error':'' }}">
									<label class="control-label">Nro. Puerta</label>
									<input type="number" value="{{ old('num_puerta') }}" name="num_puerta" class="form-control" placeholder="Ej. #235">
									<span class="help-block">{{ $errors->first('num_puerta') }}</span>
								</div>

								<div class="form-group {{ $errors->has('telefono')?'has-error':'' }} col-md-6">
									<label class="control-label">Nro. Telefono</label>
									<input type="number" value="{{ old('telefono') }}" name="telefono" class="form-control" placeholder="Ej. 2348343">
									<span class="help-block">{{ $errors->first('telefono') }}</span>
								</div>

								<div class="form-group {{ $errors->has('celular')?'has-error':'' }} col-md-6">
									<label class="control-label">Nro. Celular <i class="required">*</i></label>
									<input type="number" value="{{ old('celular') }}" name="celular" class="form-control" placeholder="Ej. 7232323">
									<span class="help-block">{{ $errors->first('celular') }}</span>
								</div>

								<div class="form-group {{ $errors->has('email')?'has-error':'' }} col-md-6">
									<label class="control-label">Email</label>
									<input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Ej. impuestos@gmail.com">
									<span class="help-block">{{ $errors->first('email') }}</span>
								</div>

								<div class="form-group {{ $errors->has('fax')?'has-error':'' }} col-md-6">
									<label class="control-label">Fax</label>
									<input type="number" value="{{ old('fax') }}" name="fax" class="form-control" placeholder="Ej. 73274273">
									<span class="help-block">{{ $errors->first('fax') }}</span>
								</div>
								
								<div class="form-group {{ $errors->has('foto')?'has-error':'' }}">
									<label class="control-label">Foto <i class="required">*</i></label>
									<input type="file" name="foto">
									<p class="help-block">Foto de la sucursal (png,jpg)</p>
									<span class="help-block">{{ $errors->first('foto') }}</span>
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
						<h3 class="box-title">ADMINISTRACION DE SUCURSALES</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="sucursal-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th>Nit</th>
									<th>Sucursal</th>
									<th>Departamento/ Ciudad</th>
									<th>Zona/ Calle/ Nro Puerta</th>
									<th>Telefono/ Celular </th>
									<th>Fax</th>
									<th>Foto</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($sucursal as $item)
								<tr class="{{ ($item->estado == 0)?'danger':'' }}">
									<td>{{ $item->nit }}</td>
									<td>{{ $item->nombre }}</td>
									<td>{{ $item->departamento.'/ '.$item->ciudad }}</td>
									<td>{{ $item->zona.'/ '.$item->calle.'/ '.$item->num_puerta }}</td>
									<td>{{ $item->telefono.'/'.$item->celular }}</td>
									<td>{{ $item->fax }}</td>
									<td>
										<img src="{{ URL::asset('storage/'.$item->foto) }}" width="100rem"   height="100rem">
									</td>
									<td>
										<div class="btn-group">
											<a href="{{ url('editar_sucursal/'.$item->id) }}" data-balloon="Editar Sucursal" data-balloon-pos="up" type="button" class="btn btn-warning">
												<i class="fa fa-edit"></i>
											</a>
											@if ($item->estado == 0)
												<a href="{{ url('restore_sucursal/'.$item->id) }}" data-balloon="Restaurar" data-balloon-pos="up" type="button" class="btn btn-success">
													<i class="fa fa-thumbs-o-up"></i>
												</a>
											@else
												<a href="{{ url('delete_sucursal/'.$item->id) }}" data-balloon="Eliminar Sucursal" data-balloon-pos="up" type="button" class="btn btn-danger">
													<i class="fa fa-trash"></i>
												</a>
											@endif
											@if ($item->estado != 0)
												<a href="{{ url('sucursal/'.$item->id) }}" data-balloon-length="medium" data-balloon="Ingresar a la sucursal para la creacion de almacenes y areas dentro de la sucursal." data-balloon-pos="up" type="button" class="btn btn-info">
												<i class="fa fa-folder-o"></i>
											@endif
											</a>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>Nit</th>
									<th>Sucursal</th>
									<th>Departamento/ Ciudad</th>
									<th>Zona/ Calle/ Nro Puerta</th>
									<th>Telefono/ Celular </th>
									<th>Fax</th>
									<th>Foto</th>
									<th>Acción</th>
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
		$('#sucursal-table').DataTable({
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2,3,4,5,6,7],
				"className": "text-center",
			},],
		});
	})
</script>
@endsection