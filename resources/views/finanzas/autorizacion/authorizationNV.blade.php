@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion de Nota de venta Finanzas</h4>
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
							<td class="text-center"><a href="{{route('verAutFinanzasNV', ['notaVenta' => $notaVenta->id])}}"><strong>{{$notaVenta->numero}}</strong></a></td>
							<td class="text-center">{{$notaVenta->cliente->rut}}</td>
							<td>{{$notaVenta->cliente->descripcion}}</td>
							<td class="text-right">{{number_format($notaVenta->total,0,",",".")}}</td>
							<td class="text-center">{{$notaVenta->cliente->formaPago->descripcion}}</td>
							<td class="text-center">
								<!-- Forms -->
								<form style="display: inline" action="{{route('autorizarFinanzasNV',['notaVenta' => $notaVenta->id])}}" method="post" v-on:submit="confirmAutorizar">
									{{csrf_field()}}
									<button class="btn btn-success btn-sm" type="submit">
										<i class="fa fa-check-circle" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{route('desautorizarFinanzasNV',['notaVenta' => $notaVenta->id])}}" method="post" v-on:submit="confirmDesautorizar">
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
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/comercial/nvAutorizacion.js')}}"></script>
@endsection
