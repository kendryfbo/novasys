@extends('layouts.master')

@section('content')

	<div class="panel panel-default">

		<div class="panel-heading text-center">
			<h4>Familias</h4>

			@if (session('status'))
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
				  </button>
				  <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
				  <strong>Info!</strong> {{session('status')}}
				</div>
			@endif

		</div>
		<br>
		<div class="container">
			<div class="container">
				<a class="col-sm-offset-11 btn btn-primary" href="{{route('crearFamilia')}}">Crear</a>
			</div>
			<br>
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
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
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$familia->codigo}}</td>
						<td>{{$familia->descripcion}}</td>
						<td>{{$familia->tipo->descripcion}}</td>
						<td>{{$familia->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarFamilia',['familia' => $familia->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarFamilia',['familia' => $familia->id])}}" method="post">
								{{csrf_field()}}
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
					</tr>

				@endforeach
			</table>
		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('js/desarrollo/familia.js')}}"></script>
@endsection
