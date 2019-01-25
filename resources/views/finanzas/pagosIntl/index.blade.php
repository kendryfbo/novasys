@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Pago Facturas de Cliente Internacional</h4>
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

			<form action="{{route('crearPagoFactIntl')}}" method="get">
				{{ csrf_field() }}
				<div class="col-lg-4">
					<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="clienteID">
						@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-lg-1">
					<button type="submit" class="btn btn-primary btn-sm">Crear Pago</button>
				</div>
			</form>
	</div>
	<!-- box-body -->
		<div class="box-body">
		<!-- table -->
		<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">CLIENTE</th>
					<th class="text-center">FACT. N°</th>
					<th class="text-center">FECHA PAGO</th>
					<th class="text-center">MONTO</th>
					<th class="text-center">OPCIONES</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($pagos as $pago)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<td class="text-center">{{$pago->Factura->clienteIntl->descripcion}}</td>
						<td class="text-center">{{$pago->Factura->numero}}</td>
						<td class="text-center">{{$pago->fecha_pago->format('d-m-Y')}}</td>
						<td class="text-center">USD {{$pago->monto}}</td>
						<td class="text-center">
							<form style="display: inline" action="{{route('eliminarPagoIntl')}}" method="post">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<input type="hidden" name="pagoID" value="{{$pago->id}}">
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
