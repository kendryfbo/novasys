@extends('layouts.master')

@section('content')
<!-- box -->
<div id="vue-app" class="box box-solid box-default">
	<!-- box-header -->
	<div class="box-header text-center">
		<h4>Ver Formulka</h4>
	</div>
	<!-- /box-header -->
	<!-- box-body -->
	<div class="box-body">

		@if ($errors->any())

			@foreach ($errors->all() as $error)

				@component('components.errors.validation')
					@slot('errors')
						{{$error}}
					@endslot
				@endcomponent

			@endforeach

		@endif

		<!-- form-horizontal -->
		<form  id="update" class="form-horizontal" method="post" action="">

				<div class="form-group">

					<label class="control-label col-lg-1" >Producto:</label>
					<div class="col-lg-5">
						<input class="form-control input-sm" type="text" name="productoID" value="{{$formula->producto->descripcion}}" readonly>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Premezcla:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" type="text" value="{{$formula->premezcla->descripcion}}" readonly>
					</div>

					<label class="control-label col-lg-1" >Reproceso:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" type="text" value="{{$formula->reproceso->descripcion}}" readonly>
					</div>

					<label class="control-label col-lg-1" >Formato:</label>
					<div class="col-lg-1">
						<input type="text" class="form-control input-sm" placeholder="Formato de Producto" value="{{$formula->producto->formato->descripcion}}" readonly required>
					</div>
					<label class="control-label col-lg-1" >Batch:</label>
					<div class="col-lg-1">
						<div class="input-group">
							<input class="form-control input-sm" type="number" value="{{$formula->cant_batch}}" readonly>
							<span class="input-group-addon">Kg</span>
						</div>
					</div>

				</div>

		</form>
		<!-- /form-horizontal -->
	</div>
	<!-- /box-body -->
	<!-- box-body -->
	<div class="box-body">
		<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

		<thead>
			<tr>
				<th class="text-center">#</th>
				<th class="text-center">DESCRIPCION</th>
				<th class="text-center">Nivel</th>
				<th class="text-center">C. Unidad</th>
				<th class="text-center">C. Caja</th>
				<th class="text-center">C. Batch</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($formula->detalle as $detalle)
			<tr>
				<td class="text-center">{{$loop->iteration}}</td>
				<td>{{$detalle->descripcion}}</td>
				<td class="text-right">{{$detalle->nivel->descripcion}}</td>
				<td class="text-right">{{$detalle->cantxuni}}</td>
				<td class="text-right">{{$detalle->cantxcaja}}</td>
				<td class="text-right">{{$detalle->cantxbatch}}</td>
			</tr>
			@endforeach
		</tbody>

		</table>
	</div>
	<!-- /box-body -->

</div>
<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
