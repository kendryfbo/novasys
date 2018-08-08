@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Facturas Internacionales</h4>
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
			<form id="download" action="{{route('descargarReportFactExcel')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="pais_id" value="{{$busqueda ? $busqueda->pais_id : ''}}">
				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
				<input type="hidden" name="desde" value="{{$busqueda ? $busqueda->desde : ''}}">
				<input type="hidden" name="hasta" value="{{$busqueda ? $busqueda->hasta : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('verInformeIntlFactura')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Pais:</label>
					<div class="col-lg-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="pais_id">

						<option value="">Todos...</option>

						@foreach ($paises as $pais)

							<option {{$pais->id == $busqueda->pais_id ? 'selected':''}} value="{{$pais->id}}">{{$pais->nombre}}</option>

						@endforeach

					  </select>
					</div>

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">

							<option value="">Todos...</option>

							@foreach ($clientes as $cliente)

								<option {{$cliente->id == $busqueda->cliente_id ? 'selected':''}} value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

							@endforeach

						</select>
					</div>

					@if ($facturas)

						<div class="col-lg-1 pull-right">
								<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						</div>

					@endif

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">F. Desde:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="desde" value="{{$busqueda->desde}}">
					</div>

					<label class="control-label col-lg-1">F. Hasta:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="hasta" value="{{$busqueda->hasta}}">
					</div>

					<div class="col-lg-1 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>
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
						<th class="text-center">Empresa</th>
						<th class="text-center">numero</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Pais</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Proforma</th>
						<th class="text-center">F.O.B</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($facturas as $factura)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$factura->centro_venta}}</td>
							<td class="text-center"><a href="{{url('comercial/FacturaIntl/'.$factura->numero)}}" target="_blank"><strong>{{$factura->numero}}</strong></a></td>
							<td class="text-left">{{$factura->cliente}}</td>
							<td class="text-left">{{$factura->clienteIntl->pais->nombre}}</td>
							<td class="text-center">{{$factura->fecha_emision}}</td>
							<td class="text-center"><a href="{{url('comercial/proformas/'.$factura->proforma)}}" target="_blank"><strong>{{$factura->proforma}}</strong></a></td>
							<td class="text-right">{{'US$ ' . number_format($factura->fob,2,",",".")}}</td>
							<td class="text-right">{{'US$ ' . number_format($factura->total,2,",",".")}}</td>
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
