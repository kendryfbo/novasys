@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Premezclas</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearPremezcla')}}">Crear</a>
		</div>
		<div class="box-body">
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>Descripcion</th>
						<th>Marca</th>
						<th>Sabor</th>
						<th>Unidad</th>
						<th>Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($premezclas as $premezcla)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$premezcla->codigo}}</td>
						<td>{{$premezcla->descripcion}}</td>
						<td>{{$premezcla->marca->descripcion}}</td>
						<td>{{$premezcla->sabor->descripcion}}</td>
						<td>{{$premezcla->unidad_med}}</td>
						<td>{{$premezcla->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarPremezcla',['premezcla' => $premezcla->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarPremezcla',['premezcla' => $premezcla->id])}}" method="post">
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
