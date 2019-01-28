<dl class="dl-horizontal">
	<dt>CODIGO SIAF</dt>
		<dd>{{ $equipo->codigo_siaf }}</dd>
	<dt>NRO. SERIE</dt>
		<dd>{{ $equipo->nro_serie }}</dd>
	<dt>MARCA</dt>
		<dd>{{ $equipo->marca }}</dd>
	<dt>MODELO</dt>
		<dd>{{ $equipo->modelo }}</dd>
		@if ( $equipo->modelo_procesador != '')
		<dt>MODELO PROCESADOR</dt>
			<dd>{{ $equipo->modelo_procesador }}</dd>
		@endif
	<dt>DESCRIPCION</dt>
		<dd>{{ $equipo->descripcion }}</dd>
</dl>

<form role="form" id="frm_devolucion">
	<div class="box-body">
		<div class="form-group">
			<label for="exampleInputEmail1">Observaciones</label>
			<textarea id="observacion_devolucion" class="form-control" rows="3" placeholder="Solo en caso de tener averias el equipo detallar aqui ..."></textarea>
		</div>
	</div>
</form>