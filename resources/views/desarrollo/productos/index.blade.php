@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Productos</h4>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearProducto')}}">Crear</a>
		</div>
		<div class="box-body">
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
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
						<th class="text-center">Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($productos as $producto)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>
							<a href="{{route('verProducto',['codigo' => $producto->codigo])}}" target="_blank"><strong>
							{{$producto->codigo}}
							</strong></a>
						</td>
						<td>{{$producto->descripcion}}</td>
						<td>{{$producto->marca->descripcion}}</td>
						<td>{{$producto->formato->descripcion}}</td>
						<td>{{$producto->sabor->descripcion}}</td>
						<td class="text-right">{{number_format($producto->peso_bruto,2,",",".")}}</td>
						<td class="text-right">{{number_format($producto->volumen,4,",",".")}}</td>
						<td class="text-center">{{$producto->activo ? "Si" : "No"}}</td>
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
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
