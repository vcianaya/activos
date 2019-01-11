<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ url('storage/'.Auth::user()->foto ) }}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>{{ Auth::user()->nombre.' '.Auth::user()->ap_paterno }}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MENU PRINCIPAL</li>
			<li class="treeview active">
				<a href="#">
					<i class="fa fa-users"></i> <span>USUARIOS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('register_usuario') }}"><i class="fa fa-circle-o"></i> Administrar</a></li>
				</ul>
			</li>
			<li class="treeview active">
				<a href="#">
					<i class="fa fa-users"></i> <span>FUNCIONARIOS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('register_funcionario') }}"><i class="fa fa-circle-o"></i> Registrar</a></li>
					<li><a href="{{ url('list_funcionarios') }}"><i class="fa fa-circle-o"></i> Administrar</a></li>
				</ul>
			</li>

			<li class="treeview active">
				<a href="#">
					<i class="fa fa-industry"></i> <span>SUCURSALES</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('registrar_sucursal') }}"><i class="fa fa-circle-o"></i> Administrar</a></li>
				</ul>
			</li>

			<li class="treeview active">
				<a href="#">
					<i class="fa fa-cubes"></i> <span>CATEGORIAS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('registrar_categoria') }}"><i class="fa fa-circle-o"></i> Administrar</a></li>
				</ul>
			</li>

			<li class="treeview active">
				<a href="#">
					<i class="fa fa-tv"></i> <span>EQUIPOS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('registrar_equipo') }}"><i class="fa fa-circle-o text-green"></i> Registrar</a></li>
          <li><a href="{{ url('falla_tecnica') }}"><i class="fa fa-circle-o text-red"></i> Falla Tecnica</a></li>
				</ul>
			</li>

			<li class="treeview active">
				<a href="#">
					<i class="fa fa-sitemap"></i> <span>ADMINISTRACION DE ACTIVOS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="{{ url('asignar_equipo') }}"><i class="fa fa-circle-o text-green"></i> Asignar</a>
					</li>
					<li>
						<a href="{{ url('devolver_activo') }}"><i class="fa fa-circle-o text-orange"></i> Devolver</a>
					</li>
				</ul>
			</li>

			<li class="header">MOVIMIENTO DE ACTIVOS</li>
			<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
			<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
			<li><a href="#"><i class="fa fa-circle-o text-green"></i> <span>Information</span></a></li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>

	<!-- =============================================== -->