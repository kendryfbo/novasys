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
			<div class="col-lg-8">
				<!--space-->
			</div>
			<div class="col-lg-3">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="clienteID">
					@foreach ($clientes as $cliente)
					<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-1">
				<a class="pull-right btn btn-primary" href="{{route('pagarIntl')}}">Crear Pago</a>
			</div>
	</div>
	<!-- box-body -->
	<div class="box-body">
		<!-- table -->
		<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
			<thead>
			 <tr>
			   <th class="text-center">#</th>
			   <th class="text-center">CLIENTE</th>
			   <th class="text-center">FECHA</th>
			   <th class="text-center">N° FACT.</th>
			   <th class="text-center">CARGOS</th>
			   <th class="text-center">SALDO</th>
			   <th class="text-center">ABONOS</th>
			   <th class="text-center"></th>
			 </tr>
		   </thead>
		   <tbody>
			    @foreach ($facturas as $factura)
				   <tr>
					   <td class="text-center">{{$factura->id}}</td>
					   <td class="text-center">{{$factura->cliente}}</td>
					   <td class="text-center">{{$factura->fecha_emision}}</td>
					   <td class="text-right">{{$factura->numero}}</td>
					   <td class="text-right">{{$factura->total}}</td>
					   <td class="text-right"></td>
					   <td class="text-right"></td>
					   <td class="text-right"></td>
				   </tr>
			    @endforeach
		   </tbody>
		</table>
		<!-- /table -->
	</div>
	</div>
@endsection

@section('scripts')
	<script>
		var facturas = {!!$facturas!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/finanzas/pagoIntl.js')}}"></script>
@endsection
