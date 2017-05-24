@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">

			<h4>Formatos</h4>

		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearFormato')}}">Crear</a>
		</div>

		<div class="box-body">
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
				</tbody>
			</table>
		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
