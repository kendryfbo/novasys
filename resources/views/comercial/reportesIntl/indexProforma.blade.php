@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Informe Proformas</h4>
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
			<form id="download" action="{{route('descargarInformeProforma')}}" method="get">

				<input type="hidden" name="cliente" value="{{$cliente}}">
				<input type="hidden" name="desde" value="{{$desde}}">
				<input type="hidden" name="hasta" value="{{$hasta}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('verInformeProforma')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">
							<option value="">Todos...</option>
							@foreach ($clientes as $client)
								<option {{$cliente == $client->id ? 'selected':''}} value="{{$client->id}}">{{$client->descripcion}}</option>
							@endforeach
						</select>
					</div>

					<label class="control-label col-lg-1">F. Desde:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="desde" value="{{$desde}}">
					</div>

					<label class="control-label col-lg-1">F. Hasta:</label>
					<div class="col-lg-2">
						<input class="form-control" type="date" name="hasta" value="{{$hasta}}">
					</div>

					<div class="col-lg-2 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						@if ($proformas)
							<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						@endif
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
						<th class="text-center">Fecha</th>
						<th class="text-center">Neto</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($proformas as $proforma)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$proforma->centroVenta->descripcion}}</td>
							<td class="text-center"><a href="{{route('verProforma',['numero' => $proforma->numero])}}" target="_blank"><strong>{{$proforma->numero}}</strong></a></td>
							<td class="text-left">{{$proforma->cliente->descripcion}}</td>
							<td class="text-center">{{$proforma->fecha_emision}}</td>
							<td class="text-right">{{'$ ' . number_format($proforma->neto,2,",",".")}}</td>
							<td class="text-right">{{'$ ' . number_format($proforma->total,2,",",".")}}</td>
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
