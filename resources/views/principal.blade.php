@extends('master')

@section('css')
<link rel="stylesheet" href="{{ url('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content-wrapper')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Servicio de Impuestos Nacionales
			<small>SISTEMA DE CONTROL DE ACTIVOS FIJOS</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>

	<section class="content">

		<div class="col-md-6">
			<div class="box box-warning box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">TOTAL DE ACTIVOS REGISTRADOS EN EL SISTEMA</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-6">
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">TOTAL DE ACTIVOS POR SUCURSAL</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="container-donut" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">EQUIPOS REGISTRADOS EN EL SISTEMA</h3>
				</div>
				<div class="box-body table-responsive">
					<table id="equipo-table" class="table table-bordered table-striped table-hover" align="center">
						<thead>
							<tr>
								<th width="60px">Codigo SIAF</th>
								<th>MARCA</th>
								<th>MODELO</th>
								<th>PROCESADOR</th>
								<th>FECHA INGRESO</th>
								<th>VIDA UTIL</th>
								<th>FECHA DESUSO</th>
								<th>DESCRIPCION</th>
								<th>SUCURSAL</th>
								<th>ALMACEN</th>
								<th>ASIGNADO A:</th>
								<th>ACCION</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th width="60px">Codigo SIAF</th>
								<th>MARCA</th>
								<th>MODELO</th>
								<th>PROCESADOR</th>
								<th>FECHA INGRESO</th>
								<th>VIDA UTIL</th>
								<th>FECHA DESUSO</th>
								<th>DESCRIPCION</th>
								<th>SUCURSAL</th>
								<th>ALMACEN</th>
								<th>ASIGNADO A:</th>
								<th>ACCION</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

	</section>
</div>
@endsection

@section('js')
<script src="{{ url('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('template/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ url('highchart/highcharts.js') }}"></script>
<script>

	$(document).ready(function() {
		equipos ={!! $equipos !!};
		categoria = [];
		equipos_data = [];
		asignados = [];
		disponibles = [];
		total = [];
		equipos.forEach(function(equipo, index) {
			categoria.push(equipo.categoria)
			equipos_data.push({name: equipo.categoria });
			asignados.push(equipo.asignados.total);
			disponibles.push(equipo.disponibles.total);
			total.push(equipo.total);
		});
		Highcharts.chart('container', {
			chart: {
				type: 'bar'
			},
			title: {
				text: null
			},
			subtitle: {
				text: 	null
			},
			xAxis: {
				categories: categoria,
				title: {
					text: 'ACTIVOS POR CATEGORIA'
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Datos (unidades)',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' unidades'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 80,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [
			{
				name: 'Asignados',
				data: asignados
			},
			{
				name: 'Disponibles',
				data: disponibles
			},
			{
				name: 'Total',
				data: total
			},
			]
		});
	});
	$(document).ready(function() {
		sucursal ={!! $sucursal !!};
		Highcharts.chart('container-donut', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'ACTIVOS POR SUCURSAL'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Equipos',
				colorByPoint: true,
				data: sucursal
			}]
		});

		table_equipos = $('#equipo-table').DataTable({
			"processing": true,
			"aaSorting": [],
			"ajax": "{{ url('get_tiempo_vida_equipos') }}",
			"language": {
				"url": "{{ url('template/bower_components/datatables.net/spanish.json') }}"
			},
			'columnDefs': [
			{
				"targets": [0,1,2],
				"className": "text-center",
			},],
			"columns": [
			{ "data": "codigo_siaf" },
			{ "data": "marca" },
			{ "data": "modelo" },
			{ "data": "modelo_procesador" },
			{ "data": "fecha_ingreso" },
			{ "data": "vida_util" },
			{ "data": "fecha_desuso" },
			{ "data": "descripcion" },
			{ "data": "sucursal" },
			{ "data": "almacen" },
      { "data": "estado" },
			{ "data": "accion" }
			],
		});

	});
</script>
@endsection