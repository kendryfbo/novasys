@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Editar Cheque en Cartera / Cliente Nacional</h4>
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

	<!-- form start -->
	<form id="edit" class="form-horizontal" method="post" action="{{route('updateChequeCartera', ['chequeCartera' => $chequeCartera->id])}}">
		{{ csrf_field() }}
		<div class="form-group">

		  <label for="inputCodigo" class="col-sm-1 control-label">ID :</label>
		  <div class="col-sm-1">
			<input type="text" class="form-control" name="id" value="{{$chequeCartera->id}}" required readonly>
		  </div>

		  <label for="inputCodigo" class="col-sm-1 control-label">Cliente :</label>
		<div class="col-sm-3">
		  <input type="text" class="form-control" name="cliente" value="{{$chequeCartera->clienteNac->descripcion}}" required readonly>
		</div>

		<label for="inputCodigo" class="col-sm-1 control-label">Banco :</label>
	  <div class="col-sm-3">
		<input type="text" class="form-control" name="nombre_banco" value="{{$chequeCartera->banco->nombre_banco}}" required readonly>
	  </div>


		</div>


		<div class="form-group">

			<label for="inputCodigo" class="col-sm-1 control-label"></label>
	  	  <div class="col-sm-1">

	  	  </div>

		  <label for="inputDescripcion" class="col-sm-1 control-label">Núm. Doc. :</label>
		  <div class="col-sm-3">
			<input type="text" class="form-control" name="numero_cheque" value="{{$chequeCartera->numero_cheque}}" required readonly>
		  </div>

		  <label for="inputDescripcion" class="col-sm-1 control-label">Monto :</label>
		  <div class="col-sm-3">
			<input type="text" class="form-control" name="monto" value="{{$chequeCartera->monto}}" required readonly>
		  </div>

		</div>

		<div class="form-group">

			<label for="inputCodigo" class="col-sm-1 control-label"></label>
	  	  <div class="col-sm-1">

	  	  </div>

		  <label for="inputDescripcion" class="col-sm-1 control-label">Fecha Cobro :</label>
		  <div class="col-sm-3">
			<input type="date" class="form-control" name="fecha_cobro" value="{{$chequeCartera->fecha_cobro}}" required readonly>
		  </div>

		  <label for="inputDescripcion" class="col-sm-1 control-label">Fecha Real Cobro :</label>
		  <div class="col-sm-3">
			<input type="date" class="form-control" name="fecha_real_cobro" value="{{$chequeCartera->fecha_real_cobro}}" required>
		  </div>

		</div>

		<div class="form-group">

			<div class="col-sm-10">
			<button type="submit" form="edit" class="btn pull-right">Modificar</button>
			</div>

		</div>
	</form>



	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
