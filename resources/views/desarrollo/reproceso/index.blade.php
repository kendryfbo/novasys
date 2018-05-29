@extends('layouts.master')

@section('content')

	<div class="box box-solid box-default">

		<div class="box-header text-center">
			<h4>Reproceso</h1>
		</div>

		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearReproceso')}}">Crear</a>
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
						<th>Formato</th>
						<th>Activo</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($reprocesos as $reproceso)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td>{{$reproceso->codigo}}</td>
						<td>{{$reproceso->descripcion}}</td>
						<td>{{$reproceso->marca->descripcion}}</td>
						<td>{{$reproceso->sabor->descripcion}}</td>
						<td>{{$reproceso->formato->descripcion}}</td>
						<td>{{$reproceso->activo ? "Si" : "No"}}</td>
						<td class="text-center">
							<form style="display: inline" action="{{route('editarReproceso',['reproceso' => $reproceso->id])}}" method="get">
								<button class="btn btn-default btn-sm" type="submit" name="button">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</button>
							</form>
							<form  style="display: inline" action="{{route('eliminarReproceso',['reproceso' => $reproceso->id])}}" method="post">
								{{csrf_field()}}
								<button class="btn btn-default btn-sm" type="submit" name="button">
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
