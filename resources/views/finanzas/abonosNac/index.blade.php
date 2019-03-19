@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Anticipos de Cliente Nacional</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearAbonoNacional')}}">Crear Anticipo</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">N.V.</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Monto</th>
						<th class="text-center">Restante</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($abonos as $abono)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$abono->orden_despacho}}</td>
							<td class="text-center">{{$abono->clienteNacional->descripcion}}</td>
							<td class="text-center">{{$abono->fecha_abono}}</td>
							<td class="text-center">${{$abono->monto}}</td>
							<td class="text-center">${{$abono->restante}}</td>
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
