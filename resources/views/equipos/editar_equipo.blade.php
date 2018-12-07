<form id="form_equipo_update" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="box-body">
    <input type="hidden" name="id_equipo" value="{{ $equipo->id }}">
		<div class="form-group">
			<label class="control-label">Categoria <i class="required">*</i></label>
			<select id="categoria" class="form-control" name="categoria">
				<option value="">Elija una opcion</option>
				@foreach ($categoria as $item)
				<option codigo="{{ $item->codigo }}" value="{{ $item->id }}" {{ ($equipo->categoria == $item->id)?'selected':'' }}>{{ $item->nombre }}</option>
				@endforeach
			</select>
			<span class="help-block">{{ $errors->first('sucursal') }}</span>
		</div>

		<div class="form-group">
			<label class="control-label">Codigo SIAF <i class="required">*</i></label>
			<input id="codigo" name="codigo" value="{{ $equipo->codigo_siaf }}" readonly type="text" class="form-control">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Marca <i class="required">*</i></label>
			<input id="marca" name="marca" value="{{ $equipo->marca }}" type="text" class="form-control" placeholder="DELL">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Modelo <i class="required">*</i></label>
			<input id="modelo" name="modelo" value="{{ $equipo->modelo }}" type="text" class="form-control" placeholder="DELL INSPIRON">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Procesador</label>
			<input id="procesador" name="procesador" value="{{ $equipo->modelo_procesador }}" type="text" class="form-control" placeholder="378378-ee3-00">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Serie</label>
			<input id="serie" name="serie" type="text" class="form-control" value="{{ $equipo->nro_serie }}" placeholder="i7 8000">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Descripcion</label>
			<input id="descripcion" name="descripcion" value="{{ $equipo->descripcion }}" type="text" class="form-control" placeholder="Descripcion del equipo">
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label>Fecha de ingreso: <i class="required">*</i></label>
			<div class="input-group date">
				<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" class="form-control pull-right" value="{{ $equipo->fecha_ingreso }}" id="datepicker" name="datepicker">
			</div>
			<span style="color:red" class="help-block" id="err-datepicker"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Sucursal <i class="required">*</i></label>
			<select id="sucursal" class="form-control" name="sucursal">
				<option value="">Elija una opcion</option>
				@foreach ($sucursal as $item)
				<option value="{{ $item->id }}" {{ ($item->id == $almacen->id_almacen)?'selected':'' }}>{{ $item->nombre }}</option>
				@endforeach
			</select>
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Almacen <i class="required">*</i></label>
			<select class="form-control select2" style="width: 100%;" name="almacen" id="almacen">
			</select>
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label>Observaciones</label>
			<textarea id="observacion" name="observacion" class="form-control" rows="3" placeholder="Detalle la obsevacion ...">{{ $equipo->observacion }}</textarea>
		</div>
	</div>
</form>
<script value="text/javascript">
	$(document).ready(function() {

		$.ajax({
			url: "{{ url('get_almacenes_sucursal',['id_sucursal'=>$almacen->id_almacen,'id_almacen'=>$almacen->id_almacen]) }}",
			success:function(response){
				$( "#form_equipo_update" ).find('.select2').empty();
				$( "#form_equipo_update" ).find('.select2').select2({data: response.data});
			}
		});

		$( "#form_equipo_update" ).find("#categoria").change(function() {
			id_categoria = $( "#form_equipo_update" ).find('#categoria').val();
			$.ajax({
				url: "{{ url('get_codigo_categoria') }}/"+id_categoria,
				success:function(response){
					$( "#form_equipo_update" ).find("#codigo").val(response.codigo+"{{ '-'.$equipo->id }}");
				}
			});
		});


		$( "#form_equipo_update" ).find( "#sucursal" ).change(function() {
			id_sucursal = $( "#form_equipo_update" ).find('#sucursal').val();
			$.ajax({
				url: "{{ url('get_almacenes_select2') }}"+"/"+id_sucursal,
				success:function(response){
					$( "#form_equipo_update" ).find('.select2').empty();
					$( "#form_equipo_update" ).find('.select2').select2({data: response.data});
				}
			});
		});

	});
</script>