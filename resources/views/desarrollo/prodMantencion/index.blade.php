@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Productos Mantencion</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearProdMantencion')}}">Crear</a>
		</div>
		<div class="box-body">
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>Descripcion</th>
						<th>familia</th>
						<th>unidad</th>
						<th>Stock Min.</th>
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
						<td>{{$producto->familia->descripcion}}</td>
						<td>{{$producto->unidad->unidad}}</td>
						<td>{{$producto->stock_min}}</td>
						<td>{{$producto->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarProdMantencion',['producto' => $producto->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarProdMantencion',['producto' => $producto->id])}}" method="post">
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
