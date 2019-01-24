@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Historial de Facturas Pagadas</h4>
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
			<form id="download" action="{{route('descargarHistorialPagoIntlExcel')}}" method="post">
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>

				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('historialPagoIntl')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">

							<option value="">Todos...</option>

							@foreach ($clientes as $cliente)

								<option {{$cliente->id == $busqueda->cliente_id ? 'selected':''}} value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

							@endforeach


						</select>
					</div>

					<div class="col-lg-1 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>
						<div class="col-lg-1 pull-right">
								<button form="download" class="btn btn-info" type="submit" name="button">Descargar Excel</button>
						</div>
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
						<th class="text-center">FACTURA</th>
						<th class="text-center">FECHA PAGO</th>
						<th class="text-center">DOC. PAGO</th>
						<th class="text-center">CARGOS</th>
						<th class="text-center">ABONOS</th>
						<th class="text-center">SALDOS</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($pagos as $pago)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$pago->Factura->numero}}</td>
						<td class="text-center">{{$pago->fecha_pago->format('d-m-Y')}}</td>
						<td class="text-center">{{$pago->numero_documento}}</td>
						<td class="text-center">{{$pago->Factura->total}}</td>
						<td class="text-center">{{$pago->monto}}</td>
						<td class="text-center">{{$pago->saldo}}</td>
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
