@extends('layouts.master')

@section('content')

		<div class="container text-center">
			<h1>Familias</h1>
		</div>

			<div class="panel panel-default">
				<div class="panel-heading">
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
							<th class="text-center">accion</th>
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
								<input class="btn btn-sm btn-warning" form="editar-form" type="submit" value="edit">
								<input class="btn btn-sm btn-danger" form="eliminar-form" type="submit" value="delete">
							</th>
						</tr>
						<form id="editar-form" action="{{route('editarFamilia',['familia' => $familia->id])}}" method="get"></form>
						<form id="eliminar-form" action="{{route('eliminarFamilia',['familia' => $familia->id])}}" method="post">
							{{csrf_field()}}
						</form>
					@endforeach
				</table>
			</div>

@endsection
