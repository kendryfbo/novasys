@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Pago Facturas de Cliente Nacional</h4>
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

			<form action="{{route('crearPagoFactNacional')}}" method="post">
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

		<!-- /table -->
	</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
