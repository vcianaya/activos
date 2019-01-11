@extends('master')

@section('css')
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>creacion de categorias</small>
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
						<h3 class="box-title">Creacion de categorias</h3>
					</div>
					<div class="box-body">
				
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">LISTADO DE CATEGORIAS DISPONIBLES</h3>
					</div>
					<div class="box-body table-responsive">
			
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

		function notify(type, icon, message) {
			$.notify({
						// options
						icon: icon,
						message: message
					}, {
						element: 'body',
						position: null,
						type: type,
						allow_dismiss: true,
						placement: {
							from: "bottom",
							align: "right"
						},
						offset: 20,
						spacing: 10,
						z_index: 1031,
						timer: 10000,
						animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						}
					});
		}

	})
</script>
@endsection