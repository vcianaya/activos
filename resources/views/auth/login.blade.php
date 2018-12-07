<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SIN | Login</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ url('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ url('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{ url('template/bower_components/Ionicons/css/ionicons.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ url('template/dist/css/AdminLTE.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ url('template/plugins/iCheck/square/blue.css') }}">

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="../../index2.html">
				<b>Servicio de Impuestos Nacionales</b><br>SIN
			</a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<p>
				<img src="{{ url('logo/logo.png') }}" alt="">
			</p>
			<form method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
				<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
					<input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
				</div>
				<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
					<input type="password" class="form-control" placeholder="Contraseña" name="password" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
				</div>
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat">INICIAR SESSION</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 3 -->
	<script src="{{ url('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{ url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- iCheck -->
	<script src="{{ url('template/plugins/iCheck/icheck.min.js') }}"></script>
</body>
</html>



{{-- @extends('layouts.app')

@section('content')
<div class="container">
		<div class="row">
				<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
								<div class="panel-heading">Login</div>

								<div class="panel-body">
										<form class="form-horizontal" method="POST" action="{{ route('login') }}">
												{{ csrf_field() }}

												<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
														<label for="email" class="col-md-4 control-label">E-Mail Address</label>

														<div class="col-md-6">
																<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

																@if ($errors->has('email'))
																		<span class="help-block">
																				<strong>{{ $errors->first('email') }}</strong>
																		</span>
																@endif
														</div>
												</div>

												<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
														<label for="password" class="col-md-4 control-label">Password</label>

														<div class="col-md-6">
																<input id="password" type="password" class="form-control" name="password" required>

																@if ($errors->has('password'))
																		<span class="help-block">
																				<strong>{{ $errors->first('password') }}</strong>
																		</span>
																@endif
														</div>
												</div>

												<div class="form-group">
														<div class="col-md-6 col-md-offset-4">
																<div class="checkbox">
																		<label>
																				<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
																		</label>
																</div>
														</div>
												</div>

												<div class="form-group">
														<div class="col-md-8 col-md-offset-4">
																<button type="submit" class="btn btn-primary">
																		Login
																</button>

																<a class="btn btn-link" href="{{ route('password.request') }}">
																		Forgot Your Password?
																</a>
														</div>
												</div>
										</form>
								</div>
						</div>
				</div>
		</div>
</div>
@endsection
 --}}