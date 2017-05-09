@extends('layouts.master')

@section('content')

	<div class="panel panel-default">

		<div class="panel-heading text-center">
			<h4>Formatos</h4>

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
			<form action="{{route('crearFormato')}}" method="get">
				<button class="col-sm-offset-11  btn" type="submit" name="button" >Crear</button>
			</form>
			<br>
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Descripcion</th>
						<th>Unidad</th>
						<th>Peso</th>
						<th>Sobres</th>
						<th>Displays</th>
						<th>Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($formatos as $formato)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$formato->descripcion}}</td>
						<td>{{$formato->unidad_med}}</td>
						<td>{{$formato->peso}}</td>
						<td>{{$formato->sobre}}</td>
						<td>{{$formato->display}}</td>
						<td>{{$formato->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarFormato',['formato' => $formato->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarFormato',['formato' => $formato->id])}}" method="post">
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
	<script src="{{asset('js/desarrollo/formato.js')}}"></script>
@endsection
