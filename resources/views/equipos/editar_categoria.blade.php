<form id="form_categoria_update" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<input type="hidden" value="{{ $categoria->id }}" name="id">
	<div class="box-body">
		<div class="form-group">
			<label class="control-label">Codigo <i class="required">*</i></label>
			<input id="codigo" value="{{ $categoria->codigo }}" readonly name="codigo" type="text" class="form-control" placeholder="PC-XA-AB">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Categoria <i class="required">*</i></label>
			<input id="categoria" value="{{ $categoria->nombre }}" name="categoria" type="text" class="form-control" placeholder="EQUIPO DE ESCRITORIO">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Tiempo de vida util (Meses) <i class="required">*</i></label>
			<input id="tiempo_vida_util" value="{{ $categoria->vida_util }}" name="tiempo_vida_util" type="number" class="form-control" placeholder="23">
			<span class="help-block"></span>
		</div>

		<div class="form-group col-md-5">
			<label class="control-label">Foto <i class="required">*</i></label>
			<input id="foto" name="foto" type="file">
			<p>Foto de la sucursal (png,jpg)</p>
			<span class="help-block"></span>
		</div>

		<div class="form-group col-md-7">
			<img src="{{ URL::asset('storage/'.$categoria->foto) }}" width="150rem" height="150rem" class="pull-right">
		</div>

	</div>
</form>