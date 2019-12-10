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

				<div id="curve_chart" style="width: auto; height: 400px"></div>

				<!-- form -->
				<form id="download" action="" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="monthID" value="23">
					<input type="hidden" name="tipoID" value="">
					<input type="hidden" name="familiaID" value="">
				</form>
				<!-- /form -->
				<form id="clearInput" action="" method="get">
				</form>
				<!-- /form -->
				<!-- form -->
				<form class="form-horizontal" action="" method="post">

					{{ csrf_field() }}

					<!-- form-group -->
					<div class="form-group form-group-sm">

						<label class="control-label col-sm-1">Seleccione Mes:</label>
						<div class="col-sm-2">
							<input type="month" name="dateSelected" value="">
						</div>

						<div class="col-sm-2">
							<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
							<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
						</div>

						<div class="col-sm-2 pull-right text-right">



						</div>


					</div>
					<!-- /form-group -->
				</form>
				<!-- /form -->
				<hr>
				<!-- 1st Table -->
				@if ($sumaAcumuladoTotal == 0)

				@else
				<h4>Internacional</h4>
				<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="50%" align="left">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Cliente</th>
							<th class="text-center">{{$mesPasado}}</th>
							<th class="text-center">{{$mesActual}}</th>
							<th class="text-center">Index YA</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($ventaMesIntl as $venta)
						@if($venta->acumuladoAnterior == '' && $venta->acumuladoActual == '')

						@else
						<tr>
							<td class="text-center">{{$loop->iteration}}</td>
							<td class="text-center">{{$venta->client}} ({{$venta->country}})</td>
							@if ($venta->mesAnterior == '')
							<td class="text-center">-</td>
							@else
							<td class="text-center">{{number_format(($venta->mesAnterior),2,',','.')}}</td>
							@endif

							@if ($venta->mesActual == '')
							<td class="text-center" style="background-color: #FFD03B;">-</td>
							@else
							<td class="text-center" style="background-color: #FFD03B;">{{number_format(($venta->mesActual),2,',','.')}}</td>
							@endif

							@if ($venta->mesAnterior == '' || $venta->mesActual == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->mesActual / $venta->mesAnterior * 100),2,',','.')}}%</td>
							@endif
						</tr>
						@endif
						@endforeach
						<tr>
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;"></td>
							<td class="text-right" style="background-color: #002060; color: #FFFFFF;"><strong>Total</strong></td>
							@if ($sumaAnterior == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAnterior),2,',','.')}}</td>
							@endif
							@if ($sumaTotal == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotal),2,',','.')}}</td>
							@endif
							@if ($sumaTotal == '' || $sumaAnterior == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotal / $sumaAnterior * 100),2,',','.')}}%</td>
							@endif

						</tr>
					</tbody>
				</table>
					<!--end of 1st Table -->


				<!--2nd Table -->
				<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="45%" align="right">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Acum {{$lastYearSelected}}</th>
							<th class="text-center">Acum {{$yearSelected}}</th>
							<th class="text-center">Index YA</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($ventaMesIntl as $venta)
							@if($venta->acumuladoAnterior == '' && $venta->acumuladoActual == '')

							@else
						<tr>
							<td class="text-center"> </td>
							@if($venta->acumuladoAnterior == '')
							<td class="text-center">-</td>
							@else
							<td class="text-center">{{number_format(($venta->acumuladoAnterior),2,',','.')}}</td>
							@endif

							@if($venta->acumuladoActual == '')
							<td class="text-center" style="background-color: #FFD03B;">-</td>
							@else
							<td class="text-center" style="background-color: #FFD03B;">{{number_format(($venta->acumuladoActual),2,',','.')}}</td>
							@endif

							@if ($venta->acumuladoActual  == '' || $venta->acumuladoAnterior == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->acumuladoActual / $venta->acumuladoAnterior * 100),2,',','.')}}%</td>
							@endif
						</tr>
							@endif
						@endforeach
						<tr>
							<td class="text-right" style="background-color: #002060; color: #FFFFFF;"></td>
							@if ($sumaAcumuladoAnterior == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoAnterior),2,',','.')}}</td>
							@endif
							@if ($sumaAcumuladoTotal == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotal),2,',','.')}}</td>
							@endif
							@if ($sumaAcumuladoTotal == '' || $sumaAcumuladoAnterior == '')
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotal / $sumaAcumuladoAnterior * 100),2,',','.')}}%</td>
							@endif
						</tr>
					</tbody>
				</table>
				@endif
			</div>
	</div>

	@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Clientes', 'Año 2019', 'Año 2018'],
					['Ene', {{json_encode($sumaTotalEnero)}}, {{json_encode($totalLastEnero)}}],
					['Feb', {{json_encode($sumaTotalFebrero)}}, {{json_encode($totalLastFebrero)}}],
					['Mar', {{json_encode($sumaTotalMarzo)}},{{json_encode($totalLastMarzo)}}],
					['Abr', {{json_encode($sumaTotalAbril)}}, {{json_encode($totalLastAbril)}}],
					['May', {{json_encode($sumaTotalMayo)}}, {{json_encode($totalLastMayo)}}],
					['Jun', {{json_encode($sumaTotalJunio)}}, {{json_encode($totalLastJunio)}}],
					['Jul', {{json_encode($sumaTotalJulio)}}, {{json_encode($totalLastJulio)}}],
					['Ago', {{json_encode($sumaTotalAgosto)}}, {{json_encode($totalLastAgosto)}}],
					['Sep', {{json_encode($sumaTotalSeptiembre)}}, {{json_encode($totalLastSeptiembre)}}],
					['Oct', {{json_encode($sumaTotalOctubre)}}, {{json_encode($totalLastOctubre)}}],
					['Nov', {{json_encode($sumaTotalNoviembre)}}, {{json_encode($totalLastNoviembre)}}],
					['Dic', {{json_encode($sumaTotalDiciembre)}}, {{json_encode($totalLastDiciembre)}}]
        ]);

				var options = {
			    title: '',
			    hAxis: {title: '',  titleTextStyle: {color: '#333'}},
			    vAxis: {minValue: 0}
			  };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
