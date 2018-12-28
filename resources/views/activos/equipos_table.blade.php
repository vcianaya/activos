<div class="box-header with-border">
	<h3 class="box-title">EQUIPOS DISPONIBLES EN ALMACEN</h3>
</div>
<div class="box-body table-responsive">
	<table id="equipo-table" class="table table-bordered table-striped table-hover" align="center">
		<thead>
			<tr>
				<th>CATEGORIA</th>
				<th width="60px">Codigo SIAF</th>
				<th>MARCA</th>
				<th>MODELO</th>
				<th>PROCESADOR</th>
				<th>FECHA INGRESO</th>
				<th>DESCRIPCION</th>
				<th>ACCION</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($equipos as $item)
			<tr id="{{ $item->id_equipo }}">
				<td>{{ $item->categoria }}</td>
				<td>{{ $item->codigo_siaf }}</td>
				<td>{{ $item->marca }}</td>
				<td>{{ $item->modelo }}</td>
				<td>{{ $item->modelo_procesador }}</td>
				<td>{{ $item->fecha_ingreso }}</td>
				<td>{{ $item->descripcion }}</td>
				<td>
					<button type="button" class="btn btn-block btn-primary btn-xs asignar_activo">Asignar</button>
				</td>
			</tr>
			@endforeach
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
				<th>ACCION</th>
			</tr>
		</tfoot>
	</table>
</div>
<script>
	table_equipos = $('#equipo-table').DataTable({
		'pageLength':5
	});
	$("#equipo-table").on('click', '.asignar_activo', function (e) {
		e.preventDefault();
		_fila = $(this).closest('tr');
		data = table_equipos.row($(this).parents('tr')).data();
		table_equipos.row($(this).parents('tr')).remove().draw(false);
		asignados_table.row.add([
            data[0],
            data[1],
            data[2],
            data[3],
            data[4],
            data[5],
            data[6],
            '<button type="button" class="btn btn-block btn-warning btn-xs quitar_activo">Quitar</button>'
        ]).draw( false );
			equipos.push(data.DT_RowId);
			$('#equipos').val(equipos);
	});
</script>