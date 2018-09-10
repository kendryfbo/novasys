@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Stock Total</h4>
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
		</div>
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form id="download" action="{{route('descargarReportTermProcExcel')}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="maquina" value="{{$maquina}}">
				<input type="hidden" name="operador" value="{{$operador}}">
				<input type="hidden" name="turno" value="{{$turno}}">
				<input type="hidden" name="desde" value="{{$desde}}">
				<input type="hidden" name="hasta" value="{{$hasta}}">
			</form>
			<!-- /form -->

			<!-- /form -->
			<form id="clearInput" action="{{route('reporteTerminoProceso')}}" method="get">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteTerminoProceso')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">F.Desde:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="desde" value="{{$desde}}">
					</div>

					<label class="control-label col-lg-1">F.Hasta:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="hasta" value="{{$hasta}}">
					</div>

					<div class="col-lg-2 pull-right text-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Maquina:</label>
					<div class="col-lg-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="maquina">
						  	<option value="">Todos...</option>
						@foreach ($maquinas as $maq)
							<option {{$maquina == $maq ? 'selected':''}} value="{{$maq}}">{{$maq}}</option>
						@endforeach

					  </select>
					</div>

					<label class="control-label col-lg-1">Operario:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="operador">

							<option value="">Todos...</option>

							@foreach ($operadores as $oper)

								<option {{$operador == $oper ? 'selected':''}} value="{{$oper}}">{{$oper}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-lg-1">Turno:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="turno">

							<option value="">Todos...</option>

							@foreach ($turnos as $turn)

								<option {{$turno == $turn ? 'selected':''}} value="{{$turn}}">{{$turn}}</option>

							@endforeach

						</select>
					</div>

					@if ($procesos)
						<div class="col-lg-1 pull-right text-right">
								<button form="download" class="btn btn-sm btn-default" type="submit">Descargar</button>
						</div>
					@endif

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

				</div>
				<!-- /form-group -->

			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='25' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">usuario</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">U.Prod</th>
						<th class="text-center">U.Rech</th>
						<th class="text-center">Pallet</th>
						<th class="text-center">Maq.</th>
						<th class="text-center">Ope.</th>
						<th class="text-center">Turno</th>
						<th class="text-center">Lote</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($procesos as $proceso)

						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$proceso->fecha_prod}}</td>
							<td class="text-center">{{$proceso->usuario->nombre}}</td>
							<td class="text-left">{{$proceso->producto->descripcion}}</td>
							<td class="text-right">{{$proceso->producidas}}</td>
							<td class="text-right">{{$proceso->rechazadas}}</td>
							<td class="text-right">PENDIENTE</td>
							<td class="text-center">{{$proceso->maquina}}</td>
							<td class="text-center">{{$proceso->operador}}</td>
							<td class="text-center">{{$proceso->turno}}</td>
							<td class="text-right">{{$proceso->lote}}</td>
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
