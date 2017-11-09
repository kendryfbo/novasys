@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Termino de Proceso</h4>
		</div>
		<!-- /box-header -->

        <!-- /box-header -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<a class="pull-right btn btn-primary" href="{{route('crearTerminoProceso')}}">Crear</a>
		</div>
		<!-- box-body -->

		<!-- box-body -->
		<div class="box-body">

			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Lote</th>
						<th class="text-center">Fecha Prod.</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Producidas</th>
						<th class="text-center">Rechazadas</th>
						<th class="text-center">Total</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($producciones as $produccion)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$produccion->lote}}</td>
							<td class="text-center">{{$produccion->fecha_prod}}</td>
							<td class="text-left">{{$produccion->producto->descripcion}}</td>
							<td class="text-right">{{$produccion->producidas}}</td>
							<td class="text-right">{{$produccion->rechazadas}}</td>
							<td class="text-right">{{$produccion->total}}</td>
							<td class="text-center">
								<form style="display: inline" method="get" action="{{route('editarTerminoProceso',['terminoProceso' => $produccion->id])}}">
									{{csrf_field()}}
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" method="post" action="{{route('eliminarTerminoProceso',['id' => $produccion->id])}}">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- /table -->
        </div>
        <!-- /box-body -->

@endsection
@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
