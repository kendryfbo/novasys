@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ordenes de Compra pendientes Por Ingresar</h4>
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
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Proveedor</th>
						<th class="text-center">Condicion Pago</th>
						<th class="text-center">area</th>
						<th class="text-center">Total</th>
						<th class="text-center">Moneda</th>
						<th class="text-center">Tipo</th>
						<th class="text-center">Status</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ordenesCompra->orderBy('proveedor.descripcion') as $ordenCompra)
						<tr>
							<th class="text-center">{{$loop->iteration}} asd</th>
							<td class="text-center"><a href="{{route('verOrdenCompra',['numero' => $ordenCompra->numero])}}" target="_blank"><strong>{{$ordenCompra->numero}}</strong></a></td>
							<td class="text-center">{{$ordenCompra->fecha_emision}}</td>
							<td>{{$ordenCompra->proveedor->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->forma_pago}}</td>
							<td class="text-center">{{$ordenCompra->area->descripcion}}</td>
							<td class="text-right">{{number_format($ordenCompra->total,2,",",".")}}</td>
							<td class="text-center">{{$ordenCompra->moneda}}</td>
							<td class="text-center">{{$ordenCompra->tipo->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->status->descripcion}}</td>
							<td class="text-center">
								<form style="display: inline" method="post" action="{{route('crearIngOC',['numero' => $ordenCompra->numero])}}">
									{{csrf_field()}}
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-plus-square fa-sm"></i>
									</button>
								</form>
							</td>
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
