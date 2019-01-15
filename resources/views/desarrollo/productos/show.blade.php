@extends('layouts.master')


@section('content')

<div id="vue-app" class="box box-solid box-default">

	<!-- /form -->
	<form id="excel" action="{{route('descargarCostoProductoExcel',['id' => $producto->id])}}" method="get">
	</form>
	<!-- form -->
	<div class="box-header text-center">
      <h3 class="box-title">Ver Producto</h3>
    </div>
    <!-- /.box-header -->
	<ul class="nav nav-tabs">
	  	<li class="active"><a data-toggle="tab" href="#producto">Producto</a></li>
	  	@if ($detallesCosto)
	  	<li><a data-toggle="tab" href="#costo">Costo</a></li>
  		@endif
	</ul>
	<!-- tab-content -->
	<div class="tab-content">
	<!-- tab-panel -->
	<div id="producto" class="tab-pane fade in active">
		<!-- box-body -->
		<div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="">
			{{ csrf_field() }}

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2" >Codigo:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="codigo" placeholder="Codigo de Producto..." value="{{ $producto->codigo }}" readonly required>
					</div>
					@if ($errors->has('codigo'))
						@component('components.errors.validation')
							@slot('errors')
								{{$errors->get('codigo')[0]}}
							@endslot
						@endcomponent
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" >Descripcion:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ $producto->descripcion }}" readonly required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Marca:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="marca" placeholder="Descripcion de Producto..." value="{{ $producto->marca->descripcion }}" readonly required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Formato:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="formato" placeholder="Descripcion de Producto..." value="{{ $producto->formato->descripcion }}" readonly required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Sabor:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="formato" placeholder="Descripcion de Producto..." value="{{ $producto->sabor->descripcion }}" readonly required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Vida Util:</label>
					<div class="col-sm-2">
						<div class="input-group">
							<input class="form-control" type="number" min="1" step="any" class="form-control" name="vida_util" placeholder="Vida util ..." value="{{ $producto->vida_util }}" readonly required>
							<span class="input-group-addon">Meses</span>
						</div>
					</div>
				</div>
			</div>

			<div class="form-horizontal">

				<div class="form-group">

					<label class="control-label col-lg-2">Peso Bruto:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" class="form-control" name="peso_bruto" placeholder="Peso Bruto..." value="{{ $producto->peso_bruto}}" readonly required>
							<span class="input-group-addon">kg</span>
						</div>
					</div>

					<label class="control-label col-lg-1">Volumen:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" class="form-control" name="volumen" placeholder="Volumen..." value="{{ $producto->volumen }}" readonly required>
							<span class="input-group-addon">m<sup>3</sup></span>
						</div>
					</div>

					<label class="control-label col-lg-1">Peso Neto:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" class="form-control" name="peso_neto" placeholder="Peso Neto..." value="{{ $producto->peso_neto }}" readonly required>
							<span class="input-group-addon">kg</span>
						</div>
					</div>

				</div>

			</div>

			<br>

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Activo:</label>
					<div class="col-sm-4">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $producto->activo ? "checked" : "" }} readonly>
					</div>
				</div>
			</div>


		</form>
		</div>
	 	<!-- /.box-body -->
	</div>
	<!-- /tab-panel -->
	<!-- tab-panel -->
	<div id="costo" class="tab-pane fade in">
		<div class="box-body">
			@if ($detallesCosto)
			<form class="form-horizontal" action="" method="get">
				<div class="col-lg-2">
				  	<button form="excel" class="btn btn-sm btn-default" type="submit"><i class="fa fa-file" aria-hidden="true"></i> Descargar excel</button>
				</div>
				<div class="col-lg-12">
						<table id="" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th colspan="7" class="text-center">COSTOS PRODUCTO</th>
								</tr>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">codigo</th>
									<th class="text-center">descripcion</th>
									<th class="text-center">Precio</th>
									<th class="text-center">PrecioxUnidad</th>
									<th class="text-center">PrecioxCaja</th>
									<th class="text-center">PrecioxBatch</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($detallesCosto as $detalle)
										<tr>
											<th class="text-center">{{$loop->iteration}}</th>
											<td class="text-center">{{$detalle->insumo->codigo}}</td>
											<td class="text-center">{{$detalle->insumo->descripcion}}</td>
											<td class="text-right">{{abs(round($detalle->precio,2))}}</td>
											<td class="text-right">{{abs(round($detalle->precioxuni,4))}}</td>
											<td class="text-right">{{abs(round($detalle->precioxcaja,4))}}</td>
											<td class="text-right">{{abs(round($detalle->precioxbatch,4))}}</td>
										</tr>
								@endforeach
							</tbody>
							<thead>
								<tr>
									<th class="text-right" colspan="3">TOTAL:</th>
									<th class="text-right">$$ {{abs(round($detallesCosto->totalPrecio,2))}}</th>
									<th class="text-right">$$ {{abs(round($detallesCosto->totalxuni,2))}}</th>
									<th class="text-right">$$ {{abs(round($detallesCosto->totalxcaja,2))}}</th>
									<th class="text-right">$$ {{abs(round($detallesCosto->totalxbatch,2))}}</th>
								</tr>
							</thead>
						</table>
				</div>
			</form>
			@endif
		</div>
	<!-- /tab-panel -->
	</div>
  </div>
  <!-- /tab-content -->
@endsection

@section('scripts')
<script>
</script>
<script src="{{asset('vue/vue.js')}}"></script>
@endsection
