@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Orden Compra Por Insumo</h4>
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
			<form id="download" action="{{route('descargarReporteOrdenCompraInsumoPDF')}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="insumo_id" value="{{$busqueda ? $busqueda->insumo_id : ''}}">
			</form>
			<form id="downloadExcel" action="{{route('descargarReporteOrdenCompraInsumoExcel')}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="insumo_id" value="{{$busqueda ? $busqueda->insumo_id : ''}}">
			</form>

			<!-- /form -->

			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteOrdenCompraInsumo')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Insumo:</label>
					<div class="col-lg-4">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="insumo_id">
						<option value="">Todos...</option>
						@foreach ($insumos as $insumo)
							<option {{$insumo->id == $insumo->insumo_id ? 'selected':''}} value="{{$insumo->id}}">{{$insumo->descripcion}}</option>
						@endforeach
					  </select>
					</div>

					<div class="col-lg-1 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>
				</div>
				<!-- /form-group -->

				@if ($ordenes)
				<!-- form-group -->
				<div class="form-group">
						<div class="col-lg-3 pull-right text-right">
							<div class=" btn-group">
								<button form="download" class="btn btn-sm btn-default" type="submit">Descargar PDF</button>
							</div>
							<div class=" btn-group">
								<button form="downloadExcel" class="btn btn-sm btn-default" type="submit">Descargar Excel</button>
							</div>
						</div>
				</div>
				<!-- /form-group -->
				@endif

			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='25' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Proveedor</th>
						<th class="text-center">O.C</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Moneda</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ordenes as $orden)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$orden->proveedor->descripcion}}</td>
							<td class="text-center"><a href="{{route('verOrdenCompra',['numero' => $orden->numero])}}" target="_blank"><strong>{{$orden->numero}}</strong></a></td>
							<td class="text-center">{{$orden->fecha_emision}}</td>
							<td class="text-center">{{$orden->moneda}}</td>
							<td class="text-right">{{number_format($orden->total,2,",",".")}}</td>
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
