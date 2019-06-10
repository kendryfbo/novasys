@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Reporte Stock Total</h4>
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
			<form id="download" action="{{route('descargarReportStockTotalExcel')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="tipoReporte" value="{{$tipoReporte}}">
				<input type="hidden" name="bodegaID" value="{{$bodegaID}}">
				<input type="hidden" name="tipoFamilia" value="{{$tipoFamilia}}">
				<input type="hidden" name="familiaID" value="{{$familiaID}}">
				<input type="hidden" name="marcaID" value="{{$marcaID}}">
				<input type="hidden" name="formatoID" value="{{$formatoID}}">
				<input type="hidden" name="saborID" value="{{$saborID}}">

			</form>
			<!-- /form -->
			<!-- /form -->
			<form id="clearInput" action="{{route('reporteStockTotal')}}" method="get">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteStockTotal')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Stock:</label>
					<div class="col-lg-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipoReporte">

						@foreach ($tiposReporte as $tipo)
							<option {{$tipoReporte == $tipo['id'] ? 'selected':''}} value="{{$tipo['id']}}">{{$tipo['descripcion']}}</option>
						@endforeach

					  </select>
					</div>

					<label class="control-label col-lg-1">Bodega:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodegaID">
							<option value="">Todos...</option>
							@foreach ($bodegas as $bodega)
								<option {{$bodega->id == $bodegaID ? 'selected':''}} value="{{$bodega->id}}">{{$bodega->descripcion}}</option>
							@endforeach
						</select>
					</div>

					<label class="control-label col-lg-1">Tipo Producto:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipoFamilia">

							<option value="">Todos...</option>

							@foreach ($tiposProducto as $tipo)

								<option {{$tipoFamilia == $tipo->id ? 'selected':''}} value="{{$tipo->id}}">{{$tipo->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<div class="col-lg-2 pull-right text-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Familia:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="familiaID">

							<option value="">Todos...</option>

							@foreach ($familias as $familia)

								<option {{$familiaID == $familia->id ? 'selected':''}} value="{{$familia->id}}">{{$familia->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-lg-1">Marca:</label>
					<div class="col-lg-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="marcaID">
					  		<option value="">Todos...</option>
							@foreach ($marcas as $marca)
							<option {{$marca->id == $marcaID ? 'selected':''}} value="{{$marca->id}}">{{$marca->descripcion}}</option>
							@endforeach
					  </select>
					</div>

					<label class="control-label col-lg-1">Formato:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formatoID">
							<option value="">Todos...</option>
							@foreach ($formatos as $formato)
							<option {{$formatoID == $formato->id ? 'selected':''}} value="{{$formato->id}}">{{$formato->descripcion}}</option>
							@endforeach
						</select>
					</div>

					@if ($productos)

						<div class="col-lg-1 pull-right text-right">
								<button form="download" class="btn btn-sm btn-default" type="submit" name="button">Descargar</button>
						</div>

					@endif

				</div>
				<!-- /form-group -->
				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Sabor:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="saborID">

							<option value="">Todos...</option>

							@foreach ($sabores as $sabor)

								<option {{$saborID == $sabor->id ? 'selected':''}} value="{{$sabor->id}}">{{$sabor->descripcion}}</option>

							@endforeach

						</select>
					</div>

				</div>
				<!-- /form-group -->

				<!-- form-group -->
				<div class="form-group form-group-sm">

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
						<th class="text-center">Código</th>
						<th class="text-center">Descripción</th>
						<th class="text-center">Familia</th>
						<th class="text-center">Cantidad</th>
						<th class="text-center">Stock Mínimo</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($productos as $producto)
					@if ($producto->cantidad <= $producto->stock_min)
					 <tr bgcolor="#FFFF00">
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$producto->codigo}}</td>
							<td class="text-left">{{$producto->descripcion}}</td>
							<td class="text-left">{{$producto->familia}}</td>
							<td class="text-right">{{$producto->cantidad}}</td>
							<td class="text-right">{{$producto->stock_min}}</td>
						</tr>
						@else
						<tr>
 							<th class="text-center">{{$loop->iteration}}</th>
 							<td class="text-center">{{$producto->codigo}}</td>
 							<td class="text-left">{{$producto->descripcion}}</td>
 							<td class="text-left">{{$producto->familia}}</td>
 							<td class="text-right">{{$producto->cantidad}}</td>
							<td class="text-right">{{$producto->stock_min}}</td>
 						</tr>
						@endif
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
