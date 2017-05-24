@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Insumos</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearInsumo')}}">Crear</a>
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
						<th>Stock Max.</th>
						<th>Activo</th>
						<th class="text-center">Editar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($insumos as $insumo)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$insumo->codigo}}</td>
						<td>{{$insumo->descripcion}}</td>
						<td>{{$insumo->familia->descripcion}}</td>
						<td>{{$insumo->unidad_med}}</td>
						<td>{{$insumo->stock_min}}</td>
						<td>{{$insumo->stock_max}}</td>
						<td>{{$insumo->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form action="{{route('editarInsumo',['insumo' => $insumo->id])}}" method="get">
								<button class="btn btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{route('eliminarInsumo',['insumo' => $insumo->id])}}" method="post">
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
