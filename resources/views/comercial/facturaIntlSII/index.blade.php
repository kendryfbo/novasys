@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Facturas Internacionales S.I.I</h4>
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
			<!-- <a class="pull-right btn btn-primary" href="{{route('crearFacturaIntl')}}">Crear</a> -->
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
						<th class="text-center">Centro Venta</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Clausula</th>
						<th class="text-center">Condicion Pago</th>
						<th class="text-center">Total</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($facturas as $factura)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{url('comercial/FacturaIntl/'.$factura->numero)}}" target="_blank">{{$factura->numero}}</a></td>
							<td class="text-center">{{$factura->fecha_emision}}</td>
							<td class="text-center">{{$factura->centro_venta}}</td>
							<td>{{$factura->cliente}}</td>
							<td class="text-center">{{$factura->clau_venta}}</td>
							<td class="text-center">{{$factura->forma_pago}}</td>
							<td class="text-right">{{'US$ ' . number_format($factura->total,2,",",".")}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{url('comercial/FacturaIntl/'.$factura->numero)}}" method="post">
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
