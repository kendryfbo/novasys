@extends('layouts.mainmaster')

@section('title', 'Main')

@include('layouts.mainnav')

@section('content')

	<div class="container col-8 offset-2">
		<div class="text-center">
			<br>
			<h1>Novasys <span class="badge badge-default">2.0</span></h1>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="{{ url('/desarrollo') }}" class="card-link">
					<img src="images/desarrollo.jpg" alt="Desarrollo" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Desarrollo</h5>
	    			</div>
				</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="{{url('/comercial')}}" class="card-link">
					<img src="images/comercial.png" alt="Comercial" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Comercial</h5>
	    			</div>
				</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="#" class="card-link">
					<img src="images/finanzas.png" alt="Finanzas" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Finanzas</h5>
	    			</div>
				</a>
				</div>
			</div>
		</div>	<!-- row -->
		<br>
		<div class="row">
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="{{url("/operaciones")}}" class="card-link">
					<img src="images/operaciones.png" alt="Operaciones" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Operaciones</h5>
	    			</div>
				</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="#" class="card-link">
					<img src="images/calidad.png" alt="Calidad" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Calidad</h5>
	    			</div>
				</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card text-center" style="border-color: #333;">
				<a href="#" class="card-link">
					<img src="images/informes.png" alt="Informes" class="rounded mx-auto d-block" style="width: 8rem;">
					<div class="card-block">
	    				<h5 class="card-title">Informes</h5>
	    			</div>
				</a>
				</div>
			</div>
		</div>	<!-- row -->
	</div>	<!-- Jumbotron -->

@endsection
