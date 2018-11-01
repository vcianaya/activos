<form role="form" id="frm_area">
	{{ csrf_field() }}
	<div class="box-body">
		<input type="hidden" id="id_area" value="{{ $area->id }}">
		<div class="form-group">
			<label class="control-label">Area <i class="required">*</i></label>
			<input id="area" value="{{ $area->nombre }}" type="text" class="form-control" placeholder="Legal">
			<span class="help-block"></span>
		</div>
		<div class="form-group">
			<label class="control-label">Descripcion <i class="required">*</i></label>
			<input id="area_descripcion" value="{{ $area->descripcion }}" type="text" class="form-control" placeholder="Area Legal de impuestos nacioanles">
			<span class="help-block"></span>
		</div>
	</div>
</form>