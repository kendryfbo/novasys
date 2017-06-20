@extends('layouts.master2')


@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Pantalla Principal Modulo de Comercial</h3>
		</div>
		<div class="box-body text-center">
			<p>Cualquier informacion interesenta acerca del modulo de comercial</p>
		</div>
		<div class="box-footer">
			<a href="{{route('email')}}" class="btn btn-info btn-lg">Enviar Email</a>
		</div>
	</div>
@endsection
