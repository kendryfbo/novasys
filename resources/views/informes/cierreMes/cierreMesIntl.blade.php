	@extends('layouts.masterInforme')

	@section('content')
		<!-- box -->
		<div id="vue-app" class="box box-solid box-default">
			<!-- box-header -->
			<div class="box-header text-center">
				<h4>Ventas Mercado Internacional </h4>
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


				<div class="form_group" id="curve_chart" style="width: auto; height: 600px"></div>

				<form id="filter" class="form-group form-group-sm" method="get" action="{{route('cierreMesIntl')}}">

						<label class="control-label col-sm-1">{{$years[0]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="actualYear" {{$yearOptions[0] ? 'checked' : ''}}>
						</div>
						<label class="control-label col-sm-1">{{$years[1]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="lastYear" {{$yearOptions[1] ? 'checked' : ''}}>
						</div>
						<label class="control-label col-sm-1">{{$years[2]}}</label>
						<div class="col-sm-1">
							<input type="checkbox" name="previousYear" {{$yearOptions[2] ? 'checked' : ''}}>
						</div>
						<input type="hidden" name="filter" value="true" checked>

				 	 	<button type="submit" form="filter" class="btn btn-default">Filtrar</button>

				</form>
				<!-- form -->
				<!-- /form -->
				<form id="clearInput" action="" method="get">
				</form>
				<!-- /form -->
				<!-- form -->
				<form id="ventaMes" class="form-horizontal" action="" method="post">
					{{ csrf_field() }}

					<!-- form-group -->
					<div class="form-group form-group-sm">

						<label class="control-label col-sm-1">Seleccione Mes:</label>
						<div class="col-sm-2">
							<input type="month" name="dateSelected" value="">
						</div>

						<div class="col-sm-2">
							<button class="btn btn-sm btn-primary" type="submit" form="ventaMes">Ver Detalle</button>
							<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
						</div>

					</div>
					<!-- /form-group -->
				</form>
				<!-- /form -->
				<hr>
				<!-- 1st Table -->
				@if (empty($ventasMesIntl))

				@else
				<h4>Internacional</h4>
				<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="100%" align="left">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">EMPRESA</th>
							<th class="text-center">FACTURA</th>
							<th class="text-center">FECHA</th>
							<th class="text-center">PROFORMA</th>
							<th class="text-center">PAÍS</th>
							<th class="text-center">CLIENTE</th>
							<th class="text-center">FOB</th>
							<th class="text-center">FECHA LISTO</th>
							<th class="text-center">FECHA CARGA</th>
							<th class="text-center">FECHA ZARPE</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($ventasMesIntl as $ventaIntl)
						<tr>
							<td class="text-center">{{$loop->iteration}}</td>
							<td class="text-center">{{$ventaIntl->centro_venta}}</td>
							<td class="text-center">{{$ventaIntl->numero}}</td>
							<td class="text-center">{{$ventaIntl->fecha_emision}}</td>
							<td class="text-center">{{$ventaIntl->proforma}}</td>
							<td class="text-center">{{$ventaIntl->country}}</td>
							<td class="text-center">{{$ventaIntl->cliente}}</td>
							<td class="text-center">{{$ventaIntl->fob}}</td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
						</tr>
						@endforeach
						<tr>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"><strong>TOTAL</strong></td>
							<td class="text-center">{{$totalVentasMesIntl[0]->mesActual}}</td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
						</tr>
					</tbody>
				</table>
					<!--end of 1st Table -->
				@endif
			</div>




	</div>

	@endsection

@section('scripts')
<script>

	var data = {!!json_encode($data)!!};
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/informes/cierreMes/cierreMesIntlChart.js')}}"></script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
