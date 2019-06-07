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
			<form id="download" action="{{route('reporteBodegaExcel')}}" method="post">
				{{ csrf_field() }}

				<input type="hidden" name="bodegaID" value="{{$bodegaID}}">
				<input type="hidden" name="tipoID" value="{{$tipoID}}">
				<input type="hidden" name="familiaID" value="{{$familiaID}}">
				<input type="hidden" name="marcaID" value="{{$marcaID}}">
				<input type="hidden" name="saborID" value="{{$saborID}}">
				<input type="hidden" name="formatoID" value="{{$formatoID}}">
			</form>
			<!-- /form -->
			<form id="clearInput" action="{{route('reporteBodega')}}" method="get">
			</form>
			<!-- /form -->
			<!-- form -->
			<form class="form-horizontal" action="{{Route('reporteBodega')}}" method="post">

				{{ csrf_field() }}

				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-sm-1">Bodega:</label>
					<div class="col-sm-2">
					  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodegaID">

						<option value="">Todas...</option>

						@foreach ($bodegas as $bod)

							<option {{$bod->id == $bodegaID ? 'selected':''}} value="{{$bod->id}}">{{$bod->descripcion}}</option>

						@endforeach

					  </select>
					</div>

					<label class="control-label col-sm-1">Tipo Producto:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipoID">

							<option value="">Todos...</option>

							@foreach ($tiposProducto as $tp)

								<option {{$tp->id == $tipoID ? 'selected':''}} value="{{$tp->id}}">{{$tp->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-sm-1">Familia:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="familiaID">

							<option value="">Todos...</option>

							@foreach ($familias as $familia)

								<option {{$familia->id == $familiaID ? 'selected':''}} value="{{$familia->id}}">{{$familia->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<div class="col-sm-2 pull-right text-right">
						<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
						<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
					</div>

				</div>
				<!-- /form-group -->
				<!-- form-group -->
				<div class="form-group form-group-sm">

					<label class="control-label col-sm-1">Marca:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="marcaID">

							<option value="">Todos...</option>

							@foreach ($marcas as $marca)

								<option {{$marca->id == $marcaID ? 'selected':''}} value="{{$marca->id}}">{{$marca->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-sm-1">Formato:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formatoID">

							<option value="">Todos...</option>

							@foreach ($formatos as $formato)

								<option {{$formato->id == $formatoID ? 'selected':''}} value="{{$formato->id}}">{{$formato->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<label class="control-label col-sm-1">Sabor:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="saborID">

							<option value="">Todos...</option>

							@foreach ($sabores as $sabor)

								<option {{$sabor->id == $saborID ? 'selected':''}} value="{{$sabor->id}}">{{$sabor->descripcion}}</option>

							@endforeach

						</select>
					</div>

					<div class="col-sm-2 pull-right text-right">
						@if ($productos)
							<button form="download" class="btn btn-sm btn-default align-right" type="submit" name="button">Descargar</button>
						@endif
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
						<th class="text-center">pallet</th>
						<th class="text-center">Codigo</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Cantidad</th>
            <th class="text-center">Fecha Ing.</th>
						<th class="text-center">Fecha Venc.</th>
						<th class="text-center">Vida Util</th>
					</tr>
				</thead>
				<tbody>

					@if ($bodegaID == '2')
					@foreach ($productos as $producto)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">222</td>
							<td class="text-center">{{$producto->pos}}</td>
							<td class="text-left">{{$producto->pallet_num}}</td>
							<td class="text-left">{{$producto->codigo}}</td>
							<td class="text-left">{{$producto->descripcion}}</td>
							<td class="text-right">{{$producto->cantidad}}</td>
							<td class="text-center">{{$producto->fecha_ing}}</td>
							<td class="text-center">{{$producto->fecha_venc}}</td>
							<td class="text-right">{{$producto->vida_util}}</td>
						</tr>
					@endforeach
					@endif

					@foreach ($productos as $producto)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-left">{{$producto->bod_descripcion}}</td>
              <td class="text-center">{{$producto->pos}}</td>
              <td class="text-left">{{$producto->pallet_num}}</td>
							<td class="text-left">{{$producto->codigo}}</td>
							<td class="text-left">{{$producto->descripcion}}</td>
							<td class="text-right">{{$producto->cantidad}}</td>
							<td class="text-center">{{$producto->fecha_ing}}</td>
							<td class="text-center">{{$producto->fecha_venc}}</td>
							<td class="text-right">{{$producto->vida_util}}</td>
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
