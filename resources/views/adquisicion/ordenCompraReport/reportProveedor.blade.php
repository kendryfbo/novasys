@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Orden Compra Por proveedor</h4>
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
			<form id="download" action="{{route('descargarReporteOrdenCompraProveedorPDF')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="proveedor_id" value="{{$busqueda ? $busqueda->proveedor_id : ''}}">
				<input type="hidden" name="desde" value="{{$busqueda ? $busqueda->desde : ''}}">
				<input type="hidden" name="hasta" value="{{$busqueda ? $busqueda->hasta : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form id="downloadDet" action="{{route('descargarReporteDetOrdenCompraProveedorPDF')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="proveedor_id" value="{{$busqueda ? $busqueda->proveedor_id : ''}}">
				<input type="hidden" name="desde" value="{{$busqueda ? $busqueda->desde : ''}}">
				<input type="hidden" name="hasta" value="{{$busqueda ? $busqueda->hasta : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteOrdenCompraProveedor')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Proveedor:</label>
					<div class="col-lg-4">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="proveedor_id">
						<option value="">Todos...</option>
						@foreach ($proveedores as $proveedor)
							<option {{$proveedor->id == $busqueda->proveedor_id ? 'selected':''}} value="{{$proveedor->id}}">{{$proveedor->rut ." - ". $proveedor->descripcion}}</option>
						@endforeach
					  </select>
					</div>

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

				@if ($ordenes)
				<!-- form-group -->
				<div class="form-group">
						<div class="col-lg-3 pull-right text-right">
							<div class=" btn-group">
								<button form="download" class="btn btn-sm btn-default" type="submit">Descargar</button>
								<button form="downloadDet" class="btn btn-sm btn-default" type="submit">Descargar-Detalle</button>
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
