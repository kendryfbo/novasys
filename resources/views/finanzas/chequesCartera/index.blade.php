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
	</div>
	<!-- box-body -->
		<div class="box-body">
		<!-- table -->
		<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">CLIENTE</th>
					<th class="text-center">N° CHEQUE</th>
					<th class="text-center">FECHA VCTO.</th>
					<th class="text-center">MONTO</th>
					<th class="text-center">BANCO</th>
					<th class="text-center">AUT. DEPÓSITO</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($chequesCartera as $chequeCartera)
					<tr>
						<th class="text-center">{{$loop->iteration}}</th>
						<th class="text-center">{{$chequeCartera->clienteNac->descripcion}}</th>
						<th class="text-center">{{$chequeCartera->numero_cheque}}</th>
						<th class="text-center">{{$chequeCartera->fecha_cobro}}</th>
						<th class="text-center">{{$chequeCartera->monto}}</th>
						<th class="text-center">{{$chequeCartera->banco->nombre_banco}}</th>
						<th class="text-center">

							@if ($chequeCartera->aut_cobro == 1)
								Sí
							@else
								<form style="display: inline" action="{{route('autorizarChequeCartera',['chequeCartera' => $chequeCartera->id])}}" method="post">
									{{csrf_field()}}
									<button class="btn btn-success btn-sm" type="submit">
										<i class="fa fa-check-circle" aria-hidden="true"></i>
									</button>
								</form>
							@endif


							</th>
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
