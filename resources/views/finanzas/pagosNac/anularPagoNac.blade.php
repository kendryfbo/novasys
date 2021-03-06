@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Anular Pago de Facturas Nacional</h4>
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

			<!-- form -->
			<form>
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>

				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('anulaPagoNacional')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente">
							@foreach ($clientes as $cliente)
								<option {{$cliente->id == $busqueda->cliente_id ? 'selected':''}} value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
							@endforeach
						</select>
					</div>

					<div class="col-lg-3 pull-left">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">
				</div>
				<!-- /form-group -->

			</form>
			<!-- /form -->
			<hr>
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='25' cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">CLIENTE</th>
						<th class="text-center">FECHA PAGO</th>
						<th class="text-center">FACTURA N°</th>
						<th class="text-center">DOC. PAGO</th>
						<th class="text-center">MONTO PAGADO</th>
						<th class="text-center">ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($pagos as $pago)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$pago->Factura->clienteNac->descripcion}}</td>
						<td class="text-center">{{$pago->fecha_pago->format('d-m-Y')}}</td>
						<td class="text-center">{{$pago->Factura->numero}}</td>
						<td class="text-center">{{$pago->numero}}</td>
						<td class="text-center">CLP {{number_format($pago->monto, 2,',','.')}}</td>
						<td class="text-center">
							<form style="display: inline" action="{{route('eliminarPagoNacional')}}" method="post" onsubmit="return confirm('¿Está seguro de Anular el Pago?');">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<input type="hidden" name="pagoID" value="{{$pago->id}}">
								<button class="btn btn-sm btn-default" type="submit">
									<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i> Anular
								</button>
							</form></td>
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
