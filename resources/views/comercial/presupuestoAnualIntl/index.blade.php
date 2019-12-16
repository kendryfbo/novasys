@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Proyección de Ventas Internacional</h4>
		</div>
		<!-- /box-header -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearPresupuestoIntl')}}">Crear Proyección</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Año</th>
						<th class="text-center">Versión</th>
						<th class="text-center">Fecha Ingreso</th>
						<th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($presupuestoIntl as $presupuesto)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center"><a href="{{route('verPresupuestoIntl',['id' => $presupuesto->id])}}" target="_blank">{{$presupuesto->year}}</a></td>
					<td class="text-center">{{$presupuesto->version}}</td>
					<td class="text-center">{{\Carbon\Carbon::parse($presupuesto->fecha_ingreso)->format('d/m/Y')}}</td>
					<td class="text-center">
						<form style="display: inline" action="{{route('editarPresupuestoIntl',['presupuestoIntl' => $presupuesto->id])}}" method="get">
						<button class="btn btn-sm" type="submit">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
					</form>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			<!-- /table -->
		</div>

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
