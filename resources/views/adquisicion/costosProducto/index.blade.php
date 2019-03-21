@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Lista de Costos por Producto</h4>
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
			<!-- form-group -->
			<div class="form-group form-group-sm">

				<div class="col-lg-2">
					<!-- form -->
					<form id="download" action="{{route('descargarCostoProductoExcel')}}" method="post">
						{{ csrf_field() }}
						<a class="btn btn-primary" href="{{route('finanzas')}}">Volver</a>
					</form>
					<!-- /form -->
				</div>

				<div class="col-lg-3 pull-right">
						<button form="download" class="btn btn-info" type="submit" name="button">Descargar Excel</button>
				</div>

			</div>
			<!-- /form-group -->
			<!-- form-group -->
			<div class="form-group">

				<label class="control-label col-lg-1">Dólar:</label>
				<div class="col-lg-2">
					<input class="form-control" type="text" name="numero" value="{{$dollar}}" readonly>
				</div>

			</div>
			<!-- /form-group -->

		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body">

			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Código</th>
						<th class="text-center">Producto</th>
						<th class="text-center">Costo</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($costosProducto as $costoProducto)
						<tr>
							<td class="text-center">{{$loop->iteration}}</td>
							<td class="text-center">{{$costoProducto->codigo}}</td>
							<td class="text-center">{{$costoProducto->descripcion}}</td>
							<td class="text-center">{{number_format($costoProducto->total, 4,'.',',')}}</td>
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
