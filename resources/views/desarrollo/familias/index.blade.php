@extends('layouts.master')

@section('content')

	<div class="container text-center">
		<h1>Familias</h1>
		<div id="app">
			@{{ message }}
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			@if (session('status'))
				<div class="alert alert-info alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
				  </button>
				  <strong>Info!</strong> {{session('status')}}
				</div>
			@endif
			<form action="{{route('crearFamilia')}}" method="get">
				<button class="col-sm-offset-11 btn btn-success" type="submit" name="button" >Crear</button>
			</form>
		</div>
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th>#</th>
					<th>codigo</th>
					<th>Descripcion</th>
					<th>Tipo</th>
					<th>Activo</th>
					<th class="text-center">Editar</th>
					<th class="text-center">Eliminar</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($familias as $familia)
				<tr>
					<th scope="row">{{$loop->iteration}}</th>
					<th>{{$familia->codigo}}</th>
					<td>{{$familia->descripcion}}</td>
					<td>{{$familia->tipo}}</td>
					<td>{{$familia->activo}}</td>
					<th class="text-center">
						<form action="{{route('editarFamilia',['familia' => $familia->id])}}" method="get">
							<button class="btn btn-sm btn-warning" type="submit" name="button">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</button>
						</form>
					</th>
					<th class="text-center">
						<form action="{{route('eliminarFamilia',['familia' => $familia->id])}}" method="post">
							{{csrf_field()}}
							<button class="btn btn-sm btn-danger" type="submit" name="button">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</button>
						</form>
					</th>
				</tr>

			@endforeach
		</table>
	</div>

@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('vue/vue.js')}}"></script>

	<script>
	var app = new Vue({
	  el: '#app',
	  data: {
		message: 'Hello Vue!'
	  }
	})
	</script>

@endsection
