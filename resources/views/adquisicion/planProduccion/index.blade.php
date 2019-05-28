@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Planes de Produccion</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearPlanProduccion')}}">Crear Plan</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">Usuario</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($planesProduccion as $plan)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="" target="_blank"><strong>{{$plan->numero}}</strong></a></td>
							<td class="text-center">{{$plan->fecha_emision}}</td>
							<td>{{$plan->descripcion}}</td>
							<td class="text-center">{{$plan->usuario->nombre}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{Route('verPlanProduccion',['planProduccion' => $plan->id])}}" method="get">
									{{csrf_field()}}
									<button class="btn btn-sm" type="submit" name="button">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('duplicarPlanProduccion',['planProduccion' => $plan->id])}}" method="post">
									{{csrf_field()}}
									<button class="btn btn-sm" type="submit" name="button">
										<i class="fa fa-files-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('editarPlanProduccion',['planProduccion' => $plan->id])}}" method="post">
									{{csrf_field()}}
									<button class="btn btn-sm" type="submit" name="button">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('eliminarPlanProduccion',['planProduccion' => $plan->id])}}" method="post">
									{{csrf_field()}}
									{{method_field('delete')}}
									<button class="btn btn-sm" type="submit" name="button">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
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
