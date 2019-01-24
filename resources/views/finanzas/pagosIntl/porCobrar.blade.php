@extends('layouts.masterFinanzas')

@section('content')


	<style>

	table.UltimoRowWithColor tr:last-child {
	   background: #f004;
	}

	</style>
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Facturas Internacionales por Cobrar</h4>
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
			<form id="download" action="{{route('descargarFactIntlPorCobrarExcel')}}" method="post">
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>

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

							<option value="">Todos...</option>

							@foreach ($clientes as $cliente)

								<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

							@endforeach

						</select>
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

					<div class="col-lg-1 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>

					<div class="col-lg-1 pull-right">
							<button form="download" class="btn btn-info" type="submit" name="button">Descargar Excel</button>
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
						<th class="text-center">Fact. N°</th>
						<th class="text-center">Fecha Emisión</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Monto</th>
						<th class="text-center">Abonado</th>
						<th class="text-center">Saldo</th>
						<th class="text-center">Doc. de Pago</th>
						<th class="text-center">Zona</th>
						<th class="text-center">Fecha Vcto.</th>
						<th class="text-center">Fecha Vcto.</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($pagos as $pago)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/FacturaIntl/'.$pago->Factura->numero)}}" target="_blank"><strong>{{$pago->Factura->numero}}</strong></a></td>
							<td class="text-center">{{$pago->Factura->fecha_emision}}</td>
							<td class="text-left">{{$pago->Factura->cliente}}</td>
							<td class="text-center">{{$pago->Factura->total}}</td>
							<td class="text-right">{{$pago->monto}}</td>
							<td class="text-right">{{$pago->saldo}}</td>
							<td class="text-center">{{$pago->numero_documento}}</td>
							<td class="text-center">{{$pago->Factura->clienteIntl->zona}}</td>
							<td class="text-right">{{$pago->Factura->fecha_venc->format('d-m-Y')}}</td>
							<td class="text-center">{{$pago->Factura->id}}</td>
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
