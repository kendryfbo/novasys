@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Informe Facturas Nacionales</h4>
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
			<form id="download" action="{{route('descargarInformeNotaVenta')}}" method="get">

				<input type="hidden" name="cliente" value="{{$cliente}}">
				<input type="hidden" name="desde" value="{{$desde}}">
				<input type="hidden" name="hasta" value="{{$hasta}}">
				<input type="hidden" name="vendedor" value="{{$vendedor}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('verInformeNotaVenta')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-5">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">
							<option value="">Todos...</option>
							@foreach ($clientes as $client)
								<option {{$cliente == $client->id ? 'selected':''}} value="{{$client->id}}">{{$client->descripcion}}</option>
							@endforeach
						</select>
					</div>
					<label class="control-label col-lg-1">Vendedor:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="vendedor">
							<option value="">Todos...</option>
							@foreach ($vendedores as $vend)
								<option {{$vendedor == $vend->id ? 'selected':''}} value="{{$vend->id}}">{{$vend->nombre}}</option>
							@endforeach
						</select>
					</div>

					@if ($notasVenta)

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
						<input class="form-control" type="date" name="desde" value="{{$desde}}">
					</div>

					<label class="control-label col-lg-1">F. Hasta:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="hasta" value="{{$hasta}}">
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
						<th class="text-center">Vendedor</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Neto</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasVenta as $notaVenta)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$notaVenta->centroVenta->descripcion}}</td>
							<td class="text-center"><a href="{{route('verNotaVenta',['numero' => $notaVenta->numero])}}" target="_blank"><strong>{{$notaVenta->numero}}</strong></a></td>
							<td class="text-left">{{$notaVenta->cliente->descripcion}}</td>
							<td class="text-left">{{$notaVenta->vendedor->nombre}}</td>
							<td class="text-center">{{$notaVenta->fecha_emision}}</td>
							<td class="text-right">{{'$ ' . number_format($notaVenta->neto,2,",",".")}}</td>
							<td class="text-right">{{'$ ' . number_format($notaVenta->total,2,",",".")}}</td>
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
