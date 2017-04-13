@extends('layouts.master')

@section('title', 'Login')

@include('layouts.nav')

@section('content')

	<div class="jumbotron col-8 offset-2">
		<div class="text-center">
			<br>
			<h1>Novasys <span class="badge badge-default">2.0</span></h1>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="card text-center">
				<a href="{{ url('/login') }}" class="card-link">
					<div class="card-block">
	    				<h5 class="card-title">Login</h5>
	    			</div>
				</a>
				</div>
			</div>
		</div>	<!-- row -->
	</div>	<!-- Jumbotron -->

@endsection
