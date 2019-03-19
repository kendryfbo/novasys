@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Cheques en Cartera de Clientes Nacional</h4>
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
			<!-- form -->
			<form id="download" action="{{route('descargarChequesPorDepositar')}}" method="post">
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>
				<input type="hidden" name="chequeCartera" value="{{$busqueda ? $busqueda->chequeCartera : ''}}">
			</form>



			<!-- /form -->

	</div>
	<!-- box-body -->
		<div class="box-body">

					<div class="col-lg-2 pull-right">
								<button form="download" class="btn btn-info" type="submit" name="button">Descargar Excel</button>
						</div>
		<!-- table -->
		<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">CLIENTE</th>
					<th class="text-center">N° CHEQUE</th>
					<th class="text-center">FECHA COBRO</th>
					<th class="text-center">MONTO</th>
					<th class="text-center">BANCO</th>
					<th class="text-center">ESTADO</th>
					<th class="text-center">ACCIÓN</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($chequesCartera as $chequeCartera)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{$chequeCartera->clienteNac->descripcion}}</td>
						<td class="text-center">{{$chequeCartera->numero_cheque}}</td>
						<td class="text-center">{{$chequeCartera->fecha_cobro}}</td>
						<td class="text-center">{{$chequeCartera->monto}}</td>
						<td class="text-center"> @if (empty($chequeCartera->banco->nombre_banco))
							---
						@else
							{{$chequeCartera->banco->nombre_banco}}
						@endif
							</td>

						<td class="text-center">

							@if ($chequeCartera->aut_cobro == 1)
								DEPOSITADO
							@else
								EN CARTERA
							@endif


						</td>
							<td class="text-center">

								@if ($chequeCartera->aut_cobro == 1)

								@else

									<form action="{{route('editarChequeCartera',['chequeCartera' => $chequeCartera->id])}}" method="get">
										<button class="btn btn-sm" type="submit" name="button"> EDITAR
											<i class="fa fa-pencil-square-o" title="Editar" aria-hidden="true"></i>
										</button>
									</form>
								@endif


							</td>
					</tr>
				@endforeach
			</tbody>
				<tr>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"><strong>TOTAL</strong></td>
						<td class="text-center"><strong>{{$chequesCartera->sum('monto')}}</strong></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
				</tr>
		</table>
		<!-- /table -->
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
