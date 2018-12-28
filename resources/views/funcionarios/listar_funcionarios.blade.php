@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>administracion de funcionarios</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Listado de funcionarios</h3>
					</div>
					<div class="box-body table-responsive">
						<table id="funcionarios-table" class="table table-bordered table-striped table-hover" align="center">
							<thead>
								<tr>
									<th>Funcionario</th>
									<th>Fec. Nac.</th>
									<th>Departamento/Ciudad</th>
									<th>Celular</th>
									<th>Sucursal</th>
									<th>Area</th>
									<th>Cargo</th>
									<th>Foto</th>
									<th>Acción</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($funcionarios as $item)
								<tr>
									<td>{{ $item->nombre.' '.$item->ap_paterno.' '.$item->ap_materno }}</td>
									<td>{{ $item->fec_nac }}</td>
									<td>{{ $item->departamento.' / '.$item->ciudad }}</td>
									<td>{{ $item->celular }}</td>
									<td>{{ $item->sucursal }}</td>
									<td>{{ $item->area }}</td>
									<td>{{ $item->cargo }}</td>
									<td><img src="{{ URL::asset('storage/'.$item->foto) }}" width="100rem" height="100rem"></td>
									<td>
										<div class="btn-group-vertical">
                      <a type="button" class="btn btn-info btn-sm" href="{{ url('detalle_funcionario_activos/'.$item->id) }}" target="_blank">Reporte</a>
											<a type="button" class="btn btn-warning btn-sm" href="{{ url('editar_funcionario/'.$item->id) }}">Editar</a>
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
									<th>Funcionario</th>
									<th>Fec. Nac.</th>
									<th>Departamento/Ciudad</th>
									<th>Celular</th>
									<th>Sucursal</th>
									<th>Area</th>
									<th>Cargo</th>
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
		$('#funcionarios-table').DataTable({
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2,3,4,5,6,7,8],
				"className": "text-center",
			},],
		});
	});
</script>
@endsection