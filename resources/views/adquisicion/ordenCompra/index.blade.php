@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ordenes de Compra</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearOrdenCompra')}}">Crear</a>
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
						<th class="text-center">Aut.Finanzas</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ordenesCompra as $ordenCompra)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verOrdenCompra',['numero' => $ordenCompra->numero])}}" target="_blank"><strong>{{$ordenCompra->numero}}</strong></a></td>
							<td class="text-center">{{$ordenCompra->fecha_emision}}</td>
							<td>{{$ordenCompra->proveedor->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->forma_pago}}</td>
							<td class="text-center">{{$ordenCompra->area->descripcion}}</td>
							<td class="text-right">{{number_format($ordenCompra->total,2,",",".")}}</td>
							<td class="text-center">{{$ordenCompra->moneda}}</td>
							<td class="text-center">{{$ordenCompra->tipo->descripcion}}</td>
							<td class="text-center">{{$ordenCompra->status->descripcion}}</td>
							@if (is_null($ordenCompra->aut_contab))
							<td class="text-center warning">
								Pendiente
							</td>
							@elseif ($ordenCompra->aut_contab == 0)
								<td class="text-center danger">
									No
								</td>
							@else
								<td class="text-center success">
									Si
								</td>
							@endif
							<td class="text-center">
							<form style="display: inline" action="{{route('eliminarOrdenCompra', ['ordenCompra' => $ordenCompra->id])}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm btn-default" type="submit">
										<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>Eliminar
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
