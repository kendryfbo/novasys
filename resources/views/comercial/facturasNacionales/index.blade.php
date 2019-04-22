@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Facturas Nacionales</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearFactNac')}}">Crear</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Número</th>
						<th class="text-center">Centro Venta</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Nota Venta</th>
						<th>R.U.T</th>
						<th>Cliente</th>
						<th>neto</th>
						<th>Monto</th>
						<th>Condicion Pago</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($facturas as $factura)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verFactNac',['factura' => $factura->id])}}" target="_blank">{{$factura->numero}}</a></td>
							<td>{{$factura->cv_id}}</td>
							<td>{{$factura->fecha_emision}}</td>
							<td class="text-center">{{$factura->numero_nv}}</td>
							<td>{{$factura->cliente_rut}}</td>
							<td>{{$factura->cliente}}</td>
							<td class="text-right">$ {{number_format($factura->neto,0,',','.')}}</td>
							<td class="text-right">$ {{number_format($factura->total,0,',','.')}}</td>
							<td class="text-center">{{$factura->cond_pago}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{route('eliminarFactNac',['factura' => $factura->id])}}" method="post">
									{{csrf_field()}}
									{{ method_field('DELETE') }}
									<button class="btn btn-sm" type="submit">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
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
