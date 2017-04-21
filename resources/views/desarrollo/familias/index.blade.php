@extends('layouts.master')

@section('content')

		<div class="container text-center">
			<h1>Familias</h1>
		</div>
		<div class="container">
			<form action="{{route('crearFamilia')}}" method="get">
				<button class="btn btn-success" type="submit" name="button" >Crear</button>
			</form>
		</div>
		<div class="container">
			@foreach ($familias as $familia)
				<p>{{$familia->descripcion}}</p>
			@endforeach
		</div>

@endsection
