	@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">

        <!-- box-header -->
		<div class="box-header text-center">

			<h4>Autorizacion de Proformas por Finanzas</h4>

		</div>
		<!-- /box-header -->


		@if (session('status'))

            <!-- box-body -->
            <div class="box-body">

    			@component('components.panel')
    				@slot('title')
    					{{session('status')}}
    				@endslot
    			@endcomponent

            </div>
            <!-- /box-body -->

		@endif

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
					@foreach ($proformas as $proforma)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center"><a href="{{route('verAutFinanzasPF',['proforma' => $proforma->id])}}"><strong>{{$proforma->numero}}</strong></a></td>
							<td class="text-center">{{$proforma->fecha_emision}}</td>
							<td class="text-center">{{$proforma->centro_venta}}</td>
							<td>{{$proforma->cliente}}</td>
							<td class="text-center">{{$proforma->clau_venta}}</td>
							<td class="text-center">{{$proforma->forma_pago}}</td>
							<td class="text-right">{{'US$ ' . number_format($proforma->total,2,",",".")}}</td>
							<td class="text-center">

								<button form="authorize" class="btn btn-success btn-sm" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
								<button form="unauthorized" class="btn btn-danger btn-sm" type="submit">
									<i class="fa fa-ban" aria-hidden="true"></i>
								</button>

							</td>

							<!-- Forms -->
							<form id="authorize" style="display: inline" action="{{route('autorizarFinanzasPF',['proforma' => $proforma->id])}}" method="post">
								{{csrf_field()}}
							</form>
							<form id="unauthorized" style="display: inline" action="{{route('desautorizarFinanzasPF',['proforma' => $proforma->id])}}" method="post">
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
@endsection
