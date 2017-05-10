@extends('layouts.master')

@section('content')

	<div class="panel panel-default">

		<div class="panel-heading text-center">
			<h4>Productos</h4>

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
				<a class="col-sm-offset-11 btn btn-primary" href="{{route('crearProducto')}}">Crear</a>
			</div>

			<br>
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>Descripcion</th>
						<th>Marca</th>
						<th>Formato</th>
						<th>Sabor</th>
						<th>Peso Bruto</th>
						<th>Volumen</th>
						<th>Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($productos as $producto)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$producto->codigo}}</td>
						<td>{{$producto->descripcion}}</td>
						<td>{{$producto->marca->descripcion}}</td>
						<td>{{$producto->formato->descripcion}}</td>
						<td>{{$producto->sabor->descripcion}}</td>
						<td>{{$producto->peso_bruto}}</td>
						<td>{{$producto->volumen}}</td>
						<td>{{$producto->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarProducto',['producto' => $producto->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarProducto',['producto' => $producto->id])}}" method="post">
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
@endsection
