@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion de Nota de venta</h4>
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
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">R.U.T</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Monto</th>
						<th class="text-center">Condicion Pago</th>
						<th class="text-center">Autorizacion</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasVentas as $notaVenta)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/notasVentas/'.$notaVenta->numero.'/autorizar')}}" target="_blank"><strong>{{$notaVenta->numero}}</strong></a></td>
							<td class="text-center">{{$notaVenta->cliente->rut}}</td>
							<td>{{$notaVenta->cliente->descripcion}}</td>
							<td class="text-right">{{number_format($notaVenta->total,2,",",".")}}</td>
							<td class="text-center">{{$notaVenta->cliente->formaPago->descripcion}}</td>
							<td class="text-center">
									<button form="authorize" class="btn btn-success btn-sm" @click="confirmAutorizar"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
									<button form="unauthorized" class="btn btn-danger btn-sm" @click="confirmDesautorizar">
										<i class="fa fa-ban" aria-hidden="true"></i>
									</button>
							</td>
							<!-- Forms -->
							<form id="authorize" style="display: inline" action="{{url('comercial/notasVentas/autorizar/'.$notaVenta->id)}}" method="post">
								{{csrf_field()}}
							</form>
							<form id="unauthorized" style="display: inline" action="{{url('comercial/notasVentas/desautorizar/'.$notaVenta->id)}}" method="post">
								{{csrf_field()}}
							</form>
							<!-- /Forms -->
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
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/comercial/nvAutorizacion.js')}}"></script>
@endsection
