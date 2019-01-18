<blockquote>
	@foreach ($falla as $item)
	<dl class="dl-horizontal">
		<dt>Fecha de falla</dt>
		<dd>{{ $item->fec_falla }}</dd>
		<dt>Detalle falla</dt>
		<dd>{{ $item->detalle }}</dd>
		<dt>Fecha reparacion</dt>
		<dd>{{ $item->fec_reparacion }}</dd>
		<dt>Detalle reparacion</dt>
		<dd>{{ $item->detalle_reparacion }}</dd>
	</dl>
	@endforeach
</blockquote>