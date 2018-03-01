@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Bodega</h4>
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
			<form id="download" action="{{route('descargarReportFactExcel')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="pais" value="{{$busqueda ? $busqueda->pais : ''}}">
				<input type="hidden" name="cliente" value="{{$busqueda ? $busqueda->cliente : ''}}">
				<input type="hidden" name="desde" value="{{$busqueda ? $busqueda->desde : ''}}">
				<input type="hidden" name="hasta" value="{{$busqueda ? $busqueda->hasta : ''}}">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteBodega')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Bodega:</label>
					<div class="col-lg-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodega">

						<option value="">Todas...</option>

						@foreach ($bodegas as $bodega)

							<option value="{{$bodega->id}}">{{$bodega->descripcion}}</option>

						@endforeach

					  </select>
					</div>

					<label class="control-label col-lg-1">Tipo Producto:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipo">

							<option value="">Todos...</option>

							@foreach ($tiposProducto as $tipo)

								<option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>

							@endforeach

						</select>
					</div>

					@if ($productos)

						<div class="col-lg-1 pull-right">
								<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						</div>

					@endif

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">
					<div class="col-lg-1 pull-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
					</div>
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
						<th class="text-center">Bodega</th>
						<th class="text-center">Posicion</th>
						<th class="text-center">Codigo</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Cantidad</th>
                        <th class="text-center">Fecha Ing.</th>
						<th class="text-center">Fecha Venc.</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($productos as $producto)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$producto->bodega}}</td>
                            <td class="text-left">{{$producto->pos}}</td>
							<td class="text-center">{{$producto->producto->codigo}}</td>
							<td class="text-left">{{$producto->producto->descripcion}}</td>
							<td class="text-left">{{$producto->cantidad}}</td>
							<td class="text-center">ASD</td>
							<td class="text-center">{{$producto->fecha_venc}}</td>
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
