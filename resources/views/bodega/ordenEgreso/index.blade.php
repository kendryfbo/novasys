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
			<div class="btn-group pull-right">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Egreso Manual <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{route('crearEgresoManualMP')}}">Materia Prima</a></li>
                  <li><a href="{{route('crearIngManualPM')}}">Premezcla</a></li>
                  <li><a href="#">Reproceso</a></li>
                  <li><a href="#">Producto Terminado</a></li>
                </ul>
              </div>
              <a class="btn btn-primary" href="{{route('ordenEgresoPendientes')}}">Orden Egreso</a>
            </div>
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
							<td class="text-center">{{$orden->documento->descripcion}}</td>
							@if ($orden->tipo_doc == config('globalVars.TDP'))
								<td class="text-center"><a href="{{route('verProforma',['proforma' => $orden->documento->numero])}}"><strong>{{$orden->documento->numero}}</strong></a></td>
							@elseif ($orden->tipo_doc == config('glovalVars.TDNV'))
								<td class="text-center"><a href="{{route('verNotaVenta',['numero' => $orden->documento->numero])}}"><strong>{{$orden->documento->numero}}</strong></a></td>
							@else
								<td class="text-center">NO</td>
							@endif
							<td class="text-center">{{$orden->documento->cliente->descripcion}}</td>
							<td class="text-center">

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
