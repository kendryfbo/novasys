@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion Orden de Compra</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearProforma')}}">Crear</a>
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
					@foreach ($ordenesCompra as $ordenCompra)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verAutFinanzasOC',['ordenCompra' => $ordenCompra->id])}}" target="_blank"><strong>{{$ordenCompra->numero}}</strong></a></td>
							<td class="text-center">{{$ordenCompra->fecha_emision}}</td>
							<td>{{$ordenCompra->proveedor->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->forma_pago}}</td>
							<td class="text-center">{{$ordenCompra->area->descripcion}}</td>
							<td class="text-right">{{number_format($ordenCompra->total,2,",",".")}}</td>
							<td class="text-center">{{$ordenCompra->moneda}}</td>
							<td class="text-center">{{$ordenCompra->tipo->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->status->descripcion}}</td>
							<td class="text-center">
								<!-- Forms -->
								<form style="display: inline" action="{{route('autorizarFinanzasOC',['ordenCompra' => $ordenCompra->id])}}" method="post" v-on:submit="confirmAutorizar">
									{{csrf_field()}}
									<button class="btn btn-success btn-sm" type="submit">
										<i class="fa fa-check-circle" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('desautorizarFinanzasOC',['ordenCompra' => $ordenCompra->id])}}" method="post" v-on:submit="confirmDesautorizar">
									{{csrf_field()}}
									<button class="btn btn-danger btn-sm" type="submit">
										<i class="fa fa-ban" aria-hidden="true"></i>
									</button>
								</form>
								<!-- /Forms -->
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
