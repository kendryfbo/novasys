@extends('layouts.mainmaster')

@section('title', 'Ingresar')

@include('layouts.mainnav')

@section('content')

	<div class="container col-md-6 col-md-offset-3">
		<div class="text-center">
			<br>
			<h1>Novasys <span class="badge badge-default">2.0</span></h1>
		</div>
		<div class="row">
			<div class="box box-solid box-default ">
				<div class="box-header text-center">
					<h4>Acceso Novasys</h4>
				</div>
				<div class="box-body">
					@if (session('status'))
						<div class="alert alert-danger">
				  		<strong>!</strong> {{session('status')}}
						</div>
					@endif
					<form action="{{route('login')}}" method="post">

						{{ csrf_field() }}

						<div class="form-group">
					    	<label for="exampleInputEmail1">Usuario</label>
					    	<input type="text" class="form-control" name="user" placeholder="Nombre de Usuario..." required>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Contraseña</label>
							<input type="password" class="form-control" name="password" placeholder="Contraseña..." required>
						</div>
						<div class="form-group pull-center">
							<button class="btn btn-default" type="submit">Ingresar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	<!-- container -->

@endsection
