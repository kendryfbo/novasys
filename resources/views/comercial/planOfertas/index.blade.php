@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Planes de Ofertas</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearPlanOferta')}}">Crear Plan</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Nombre del Plan</th>
						<th class="text-center">Creado</th>
						<th class="text-center">Fecha Inicio</th>
						<th class="text-center">Fecha Término</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($planOfertas as $planOferta)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center">{{$planOferta->descripcion}}</td>
					<td class="text-center">{{\Carbon\Carbon::parse($planOferta->fecha_ingreso)->format('d/m/Y')}}</td>
					<td class="text-center">{{\Carbon\Carbon::parse($planOferta->fecha_inicio)->format('d/m/Y')}}</td>
					<td class="text-center">{{\Carbon\Carbon::parse($planOferta->fecha_termino)->format('d/m/Y')}}</td>
					<td class="text-center">
						<form style="display: inline" action="{{route('editarPlanOferta',['planOfertas' => $planOferta->id])}}" method="get">
						<button class="btn btn-sm" type="submit">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
					</form>
					<form style="display: inline" action="{{route('eliminarPlanOferta', ['planOfertas' => $planOferta->id])}}" method="post">
							{{csrf_field()}}
							{{ method_field('DELETE') }}
							<button class="btn btn-sm btn-default" type="submit">
								<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i> Eliminar
							</button>
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
