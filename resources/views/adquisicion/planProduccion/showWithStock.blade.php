@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- /form -->
		<form id="excel" action="{{route('descExcelAnalReqConStock')}}" method="post">
			{{ csrf_field() }}
		</form>
		<!-- form -->
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Producto Terminado</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
				<form class="form-horizontal" action="index.html" method="post">
					<div class="col-lg-12 pull-right text-right">
						<button form="excel" class="btn btn-sm btn-default" type="submit"><i class="fa fa-file" aria-hidden="true"></i> Descargar excel</button>
						<!-- Items -->
						<select form="excel" style="display: none;"  name="items[]" multiple required>
							@foreach ($items as $item)
							<option selected>
								{{$item}}
							</option>
						@endforeach
						</select>
						<!-- /items -->
					</div>
					<div class="col-lg-12">
							<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">codigo</th>
										<th class="text-center">descripcion</th>
										<th class="text-center">existencia</th>
										<th class="text-center">requerimiento</th>
										<th class="text-center">faltante</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($productos as $producto)
										<tr>
											<th class="text-center">{{$loop->iteration}}</th>
											<td class="text-center">{{$producto->codigo}}</td>
											<td class="text-center">{{$producto->descripcion}}</td>
											<td class="text-right">{{$producto->stock_total}}</td>
											<td class="text-right">{{$producto->cantidad}}</td>
											<td class="text-right">{{$producto->cant_restante}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
					</div>
				</form>
		</div>
		<hr>
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
				<form class="form-horizontal" action="index.html" method="post">
					<div class="col-lg-12">
							<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">codigo</th>
										<th class="text-center">descripcion</th>
										<th class="text-center">existencia</th>
										<th class="text-center">requerimiento</th>
										<th class="text-center">faltante</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($insumos as $insumo)
										@if ($insumo->requerida && $insumo->nivel_id == 1)
											<tr>
												<th class="text-center">{{$loop->iteration}}</th>
												<td class="text-center">{{$insumo->codigo}}</td>
												<td class="text-center">{{$insumo->descripcion}}</td>
												<td class="text-right">{{$insumo->total}}</td>
												<td class="text-right">{{$insumo->requerida}}</td>
												<td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
					</div>
				</form>
		</div>
		<!-- /box-body -->
		<hr>
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Premezcla</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
				<form class="form-horizontal" action="index.html" method="post">
					<div class="col-lg-12">
							<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">codigo</th>
										<th class="text-center">descripcion</th>
										<th class="text-center">existencia</th>
										<th class="text-center">requerimiento</th>
										<th class="text-center">faltante</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($insumos as $insumo)
										@if ($insumo->requerida && $insumo->nivel_id == 2)
											<tr>
												<th class="text-center">{{$loop->iteration}}</th>
												<td class="text-center">{{$insumo->codigo}}</td>
												<td class="text-center">{{$insumo->descripcion}}</td>
												<td class="text-right">{{$insumo->total}}</td>
												<td class="text-right">{{$insumo->requerida}}</td>
												<td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
					</div>
				</form>
		</div>
		<!-- /box-body -->
		<hr>
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Mezclado</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
				<form class="form-horizontal" action="index.html" method="post">
					<div class="col-lg-12">
							<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">codigo</th>
										<th class="text-center">descripcion</th>
										<th class="text-center">existencia</th>
										<th class="text-center">requerimiento</th>
										<th class="text-center">faltante</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($insumos as $insumo)
										@if ($insumo->requerida && $insumo->nivel_id == 3)
											<tr>
												<th class="text-center">{{$loop->iteration}}</th>
												<td class="text-center">{{$insumo->codigo}}</td>
												<td class="text-center">{{$insumo->descripcion}}</td>
												<td class="text-right">{{$insumo->total}}</td>
												<td class="text-right">{{$insumo->requerida}}</td>
												<td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
					</div>
				</form>
		</div>
		<!-- /box-body -->
		<hr>
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>General</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
				<form class="form-horizontal" action="index.html" method="post">
					<div class="col-lg-12">
							<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="text-center">codigo</th>
										<th class="text-center">descripcion</th>
										<th class="text-center">existencia</th>
										<th class="text-center">requerimiento</th>
										<th class="text-center">faltante</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($insumos as $insumo)
										@if ($insumo->requerida)
											<tr>
												<th class="text-center">{{$loop->iteration}}</th>
												<td class="text-center">{{$insumo->codigo}}</td>
												<td class="text-center">{{$insumo->descripcion}}</td>
												<td class="text-right">{{$insumo->total}}</td>
												<td class="text-right">{{$insumo->requerida}}</td>
												<td class="text-right">{{($insumo->total - $insumo->requerida) > 0 ? 0 : abs(round($insumo->requerida - $insumo->total,2))}}</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
					</div>
				</form>
		</div>
		<!-- /box-body -->

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
