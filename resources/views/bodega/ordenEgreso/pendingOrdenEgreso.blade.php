@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ordenes de Egreso Pendientes por Generar</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearBodega')}}">Crear</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">numero</th>
						<th class="text-center">Tipo</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ordenes as $orden)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$orden->numero}}</td>
							<td class="text-center">{{$orden->tipo}}</td>
							<td class="text-center">{{$orden->Cliente->descripcion}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{route('ordenEgresoConsultarExistencia',['tipo' => $orden->tipo_id,'id' => $orden->id])}}" method="post">
									{{ csrf_field() }}
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-pencil-square-o fa-eye" aria-hidden="true"></i> Existencia
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
