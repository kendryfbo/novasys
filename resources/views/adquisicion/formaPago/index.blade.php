@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Condiciones de Pago Proveedores</h4>
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
			<a class="pull-right btn btn-primary" href="{{route('crearFormaPagoProveedor')}}">Crear</a>
		</div>
		<!-- box-body -->
		<div class="box-body">
			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">activo</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($formasPagos as $formaPago)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$formaPago->descripcion}}</td>
							<td class="text-center">{{$formaPago->activo ? 'Si':'No'}}</td>
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
