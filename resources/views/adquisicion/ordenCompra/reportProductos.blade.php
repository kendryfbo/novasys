@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte por Productos -> "BORDEN"</h4>
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
			<form id="downloadExcel" action="{{route('descargaReporteProductos')}}" method="post">
				{{ csrf_field() }}
			</form>
			<div class="col-lg-1 pull-right">
				<button form="downloadExcel" class="btn btn-sm btn-default" type="submit"><i class="fa fa-download" aria-hidden="true"></i>Descargar</button>
			</div>
		</div>

		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Número</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Proveedor</th>
						<th class="text-center">Condición Pago</th>
						<th class="text-center">Área</th>
						<th class="text-center">Total</th>
						<th class="text-center">Moneda</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($productos->sortBy('proveedor.descripcion') as $producto)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verOrdenCompra',['numero' => $producto->numero])}}" target="_blank"><strong>{{$producto->numero}}</strong></a></td>
							<td class="text-center">{{$producto->fecha_emision}}</td>
							<td class="text-center">{{$producto->nombreProveedor}}</td>
							<td class="text-center">{{$producto->forma_pago}}</td>
							<td class="text-center">{{$producto->nombreArea}}</td>
							<td class="text-center">${{$producto->total}}</td>
							<td class="text-center">{{$producto->moneda}}</td>
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
