@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">

			<h4>Marcas</h4>

		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearMarca')}}">Crear</a>
		</div>

		<div class="box-body">
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>Descripcion</th>
						<th>Familia</th>
						<th>Impuesto IABA</th>
						<th>Venta Nac.</th>
						<th>Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($marcas as $marca)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td>{{$marca->codigo}}</td>
						<td>{{$marca->descripcion}}</td>
						<td>{{$marca->familia->descripcion}}</td>
						<td>{{$marca->iaba ? "Si" : "No"}}</td>
						<td>{{$marca->nacional ? "Si" : "No"}}</td>
						<td>{{$marca->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarMarca',['marca' => $marca->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarMarca',['marca' => $marca->id])}}" method="post">
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
