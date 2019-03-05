@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Facturas Nacional por Cobrar</h4>
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
			<form id="download" action="{{route('descargarFactNacionalPorCobrarExcel')}}" method="post">
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>
				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
			</form>
			<form id="downloadByZonas" action="{{route('descargarHistorialPagoNacExcelByZonas')}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">
					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">
							@foreach ($clientes as $cliente)
								<option {{$clienteID == $cliente->id ? 'selected':''}} value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
							@endforeach
						</select>
					</div>

					<div class="col-lg-2 pull-left">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">F. Desde:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="desde" value="">
					</div>

					<label class="control-label col-lg-1">F. Hasta:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="hasta" value="">
					</div>

					<div class="col-lg-2 pull-right">
							<button form="download" class="btn btn-info" type="submit" name="button">Descargar Excel</button>
					</div>

					<div class="col-lg-2 pull-right">
							<button form="downloadByZonas" class="btn btn-info" type="submit" name="button">Descargar Totales Excel</button>
					</div>


				</div>


			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='25' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">FACTURA</th>
						<th class="text-center">FECHA PAGO</th>
						<th class="text-center">O.D.</th>
						<th class="text-center">CLIENTE</th>
						<th class="text-center">DOC. PAGO</th>
						<th class="text-center">CARGOS</th>
						<th class="text-center">ABONOS</th>
						<th class="text-center">SALDOS</th>
						<th class="text-center">FECHA VENC.</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($pagos as $factura)
				<tr>
					<td class="text-center">{{$factura->numero}}</td>
					<td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
					<td class="text-center">{{$factura->proforma}}</td>
					<td class="text-center">{{$factura->cliente}}</td>
					<td class="text-center">Factura</td>
					<td class="text-center">{{number_format($factura->total, 2,'.',',')}}</td>
					<td class="text-center">0</td>

					@if(isset($factura->pagos[0]))
					<td class="text-center">0</td>
					@else
					<td class="text-center">{{number_format($factura->deuda, 2,'.',',')}}</td>
					@endif
					<td class="text-center">{{$factura->fecha_venc->format('d/m/Y')}}</td>
				</tr>
					@foreach ($factura->pagos as $pago)
					<tr>
						<td class="text-center">{{$factura->numero}}</td>
						<td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
						<td class="text-center">{{$factura->proforma}}</td>
						<td class="text-center">{{$factura->cliente}}</td>
						<td class="text-center">Abono {{$pago->numero}}</td>
						<td class="text-center">0</td>
						<td class="text-center">{{number_format($pago->monto, 2,'.',',')}}</td>
						@if ($loop->last)
							<td class="text-center">{{number_format(($factura->total - $factura->pagos->sum('monto')), 2,'.',',')}}</td>
						@else
							<td class="text-center">0</td>
						@endif
						<td class="text-center"></td>
					</tr>
					@endforeach
					<tr class="active">
						<td colspan="9"></td>
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
