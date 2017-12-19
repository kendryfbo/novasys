@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ordenes de Egreso</h4>
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
						<th class="text-center">Tipo Doc.</th>
						<th class="text-center">Num. Doc.</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ordenes as $orden)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verOrdenEgreso',['numero' => $orden->numero])}}"><strong>{{$orden->numero}}</strong></a></td>
							<td class="text-center">{{$orden->tipo_doc}}</td>
							@if ($orden->tipo_doc == config('globalVars.TDP'))
								<td class="text-center"><a href="{{route('verProforma',['proforma' => $orden->documento->numero])}}"><strong>{{$orden->documento->numero}}</strong></a></td>
							@elseif ($orden->tipo_doc == config('glovalVars.TDNV'))
								<td class="text-center"><a href="{{route('verNotaVenta',['numero' => $orden->documento->numero])}}"><strong>{{$orden->documento->numero}}</strong></a></td>
							@else
								<td class="text-center">NO</td>
							@endif
							<td class="text-center">{{$orden->documento->cliente}}</td>
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
