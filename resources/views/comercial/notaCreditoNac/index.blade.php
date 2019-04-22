@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Notas de Crédito</h4>
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
			<div class="btn-group pull-right">
					<a class="btn btn-primary btn-sm" href="{{route('crearNotaCreditoNac')}}">
						Nota Crédito Factura
					</a>
					<a class="btn btn-primary btn-sm" href="{{route('crearNotaCreditoNacCliente')}}">
						Nota Crédito Cliente
					</a>
			</div>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Centro Venta</th>
						<th class="text-center">Cliente</th>
						<th class="text-center">Factura</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Total</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notasCredito as $nota)
						<tr>
							<td class="text-center"><a href="{{route('verNotaCreditoNac', ['notaCredito' => $nota->numero])}}" target="_blank"><strong>{{$nota->numero}}</strong></a></td>
							@if ($nota->fact_id == null)
								<td class="text-center">-</td>
							@else
								<td class="text-center">{{$nota->Factura->centroVenta->descripcion}}</td>
							@endif

								<td class="text-center">{{$nota->clienteNacional->descripcion}}</td>

							@if ($nota->fact_id == null)
								<td class="text-center">-</td>
							@else
								<td class="text-center">{{$nota->Factura->numero}}</td>
							@endif
                            <td class="text-center">{{$nota->fecha}}</td>
							<td class="text-right">${{number_format($nota->total,0,',','.')}}</td>
							<td class="text-center">
								<form style="display: inline" action="{{route('eliminarNotaCreditoNac', ['notaCredito' => $nota->id])}}" method="post">
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
