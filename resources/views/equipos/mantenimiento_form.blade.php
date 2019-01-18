<link rel="stylesheet" href="{{ url('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form role="form" id="frm_falla_tecnica">
	<input type="hidden" name="id_equipo" value="{{ $id_equipo }}" name="id_equipo">
	<div class="box-body">
		{{ csrf_field() }}
		<div class="form-group">
			<label>Falla tecnica</label>
			<textarea id="detalle" name="detalle" class="form-control" rows="3" placeholder="Detallar aqui la falla encontrada ..."></textarea>
			<span class="help-block"></span>
		</div>
		<div class="form-group">
			<label>Fecha de ingreso: <i class="required">*</i></label>
			<div class="input-group date">
				<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
			</div>
			<span style="color:red" class="help-block" id="err-datepicker"></span>
		</div>
	</div>
</form>
<script src="{{ url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('template/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script>
	$('#datepicker').datepicker({
		autoclose: true,
		language: 'es',
		format: 'yyyy-mm-dd',
	});
</script>