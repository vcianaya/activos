<form role="form" id="frm_almacen">
  <div class="box-body">
    <input type="hidden" id="id_almacen" value="{{ $almacen->id }}">
    <div class="form-group">
      <label class="control-label">Almacen <i class="required">*</i></label>
      <input id="almacen" value="{{ $almacen->nombre }}" type="text" class="form-control">
      <span class="help-block"></span>
    </div>
    <div class="form-group">
      <label class="control-label">Descripcion <i class="required">*</i></label>
      <input id="almacen_descripcion" value="{{ $almacen->descripcion }}" type="text" class="form-control">
      <span class="help-block"></span>
    </div>
  </div>
</form>