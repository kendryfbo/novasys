@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Por Productos Facturas Nacionales</h4>
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
			<form id="download" action="{{route('ReportProdNacExcel')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
				<input type="hidden" name="producto" value="{{$busqueda ? $busqueda->producto : ''}}">
				<input type="hidden" name="desde" value="{{$busqueda ? $busqueda->desde : ''}}">
				<input type="hidden" name="hasta" value="{{$busqueda ? $busqueda->hasta : ''}}">
				<input type="hidden" name="group" value="{{$busqueda ? $busqueda->group : ''}}">
			</form>

			<!-- form -->
			<form class="form-horizontal" action="{{Route('verInformeNacProdFactura')}}" method="post">

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

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="producto">

							<option value="">Todos...</option>

							@foreach ($productos as $producto)

								<option value="{{$producto->id}}">{{$producto->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-lg-2">Agrupar por cliente:</label>
					<div class="col-lg-1 checkbox">
						<input type="checkbox" name="group" checked>
					</div>

					<div class="col-lg-1 pull-right">
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

					@if ($detalles)

						<div class="col-lg-1 pull-right">
							<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						</div>

					@endif

				</div>
				<!-- /form-group -->

			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">cliente</th>
						<th class="text-center">codigo</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">cantidad</th>
						<th class="text-center">precio</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($detalles as $detalle)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$detalle->cliente ? $detalle->cliente: 'GENERAL'}}</td>
							<td class="text-center">{{$detalle->codigo}}</td>
							<td class="text-left">{{$detalle->descripcion}}</td>
							<td class="text-right">{{$detalle->cantidad}}</td>
							<td class="text-right">{{$detalle->precio}}</td>
							<td class="text-right">{{'$ ' . number_format($detalle->total,2,",",".")}}</td>

						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- /table -->

		</div>
		<!-- /box-body -->
	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
