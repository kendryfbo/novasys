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
						<th>R.U.T</th>
						<th>Cliente</th>
						<th>Monto</th>
						<th>Condicion Pago</th>
						<th class="text-center">Autorizacion</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasVentas as $notaVenta)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/notasVentas/'.$notaVenta->numero)}}" target="_blank">{{$notaVenta->numero}}</a></td>
							<td>{{$notaVenta->cliente->rut}}</td>
							<td>{{$notaVenta->cliente->descripcion}}</td>
							<td>{{$notaVenta->total}}</td>
							<td>{{$notaVenta->cliente->formaPago->descripcion}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{url('comercial/notasVentas/autorizar/'.$notaVenta->id)}}" method="post">
									{{csrf_field()}}
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-check-circle" aria-hidden="true"></i>
									</button>
								</form>
								<form style="display: inline" action="{{url('comercial/notasVentas/desautorizar/'.$notaVenta->id)}}" method="post">
									{{csrf_field()}}
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-ban" aria-hidden="true"></i>
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
