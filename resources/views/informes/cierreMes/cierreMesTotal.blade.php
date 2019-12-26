	@extends('layouts.masterInforme')

	@section('content')
		<!-- box -->
		<div id="vue-app" class="box box-solid box-default">
			<!-- box-header -->
			<div class="box-header text-center">
				<h3>Ventas Mercado Nacional e Internacional</h3>
				<h6>Cierre de Mes</h6>
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

				<form id="filter" class="form-group form-group-sm" method="get" action="{{route('cierreMesTotal')}}">

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

				<hr>
					<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="100%" align="left">
						<thead>
							<tr>
								<th class="text-center">MESES</th>
								<th class="text-center">ENE</th>
								<th class="text-center">FEB</th>
								<th class="text-center">MAR</th>
								<th class="text-center">ABR</th>
								<th class="text-center">MAY</th>
								<th class="text-center">JUN</th>
								<th class="text-center">JUL</th>
								<th class="text-center">AGO</th>
								<th class="text-center">SEP</th>
								<th class="text-center">OCT</th>
								<th class="text-center">NOV</th>
								<th class="text-center">DIC</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">REAL</td>
								<td class="text-center">{{number_format((($sumaTotalEnero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalFebrero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalMarzo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalAbril)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalMayo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalJunio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalJulio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalAgosto)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalSeptiembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalOctubre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalNoviembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($sumaTotalDiciembre)),2,',','.')}}</td>
							</tr>
							<tr>
								<td class="text-center">AÑO ANT.</td>
								<td class="text-center">{{number_format((($totalLastEnero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastFebrero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastMarzo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastAbril)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastMayo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastJunio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastJulio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastAgosto)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastSeptiembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastOctubre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastNoviembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($totalLastDiciembre)),2,',','.')}}</td>
							</tr>
							<tr>
								<td class="text-center">PPTO. {{$currentYear}}</td>
								<td class="text-center">{{number_format((($presupEnero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupFebrero)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupMarzo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupAbril)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupMayo)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupJunio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupJulio)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupAgosto)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupSeptiembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupOctubre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupNoviembre)),2,',','.')}}</td>
								<td class="text-center">{{number_format((($presupDiciembre)),2,',','.')}}</td>
							</tr>
						</tbody>
					</table>

					<hr>
						<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="100%" align="left">
							<thead>
								<tr>
									<th class="text-center">ACUM.</th>
									<th class="text-center">ENE</th>
									<th class="text-center">FEB</th>
									<th class="text-center">MAR</th>
									<th class="text-center">ABR</th>
									<th class="text-center">MAY</th>
									<th class="text-center">JUN</th>
									<th class="text-center">JUL</th>
									<th class="text-center">AGO</th>
									<th class="text-center">SEP</th>
									<th class="text-center">OCT</th>
									<th class="text-center">NOV</th>
									<th class="text-center">DIC</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center">REAL</td>
									<td class="text-center">{{number_format((($sumaTotalEnero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre + $sumaTotalDiciembre)),2,',','.')}}</td>
								</tr>
								<tr>
									<td class="text-center">AÑO ANT.</td>
									<td class="text-center">{{number_format((($totalLastEnero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre + $totalLastDiciembre)),2,',','.')}}</td>
								</tr>
								<tr>
									<td class="text-center">PPTO.</td>
									<td class="text-center">{{number_format((($presupEnero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre)),2,',','.')}}</td>
									<td class="text-center">{{number_format((($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre + $presupDiciembre)),2,',','.')}}</td>
								</tr>
								<tr>
									<td colspan="13"></td>
								</tr>
								<tr>
									<td colspan="13"></td>
								</tr>
								<tr>
									<td class="text-center">Dif. Año Ant.</td>
									<td class="text-center">{{number_format(($sumaTotalEnero / $totalLastEnero * 100) - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero) / ($totalLastEnero + $totalLastFebrero) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre) * 100 - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre) * 100  - 100,2,',','.')}}%</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre + $sumaTotalDiciembre) / ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre + $totalLastDiciembre) * 100 - 100,2,',','.')}}%</td>
								</tr>
								<tr>
									<td class="text-center"></td>
									<td class="text-center">{{number_format(($sumaTotalEnero - $totalLastEnero),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero) - ($totalLastEnero + $totalLastFebrero),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre),2,',','.')}}</td>
									<td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre + $sumaTotalDiciembre) - ($totalLastEnero + $totalLastFebrero + $totalLastMarzo + $totalLastAbril + $totalLastMayo + $totalLastJunio + $totalLastJulio + $totalLastAgosto + $totalLastSeptiembre + $totalLastOctubre + $totalLastNoviembre + $totalLastDiciembre),2,',','.')}}</td>
								</tr>
								<tr>
									<td colspan="13"></td>
								</tr>
								<tr>
								  <td class="text-center">Dif. PPTO. {{$currentYear}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero / $presupEnero * 100) - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero) / ($presupEnero + $presupFebrero) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo) / ($presupEnero + $presupFebrero + $presupMarzo) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre) * 100 - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre) * 100  - 100,2,',','.')}}%</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre + $sumaTotalDiciembre) / ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre + $presupDiciembre) * 100 - 100,2,',','.')}}%</td>
								</tr>
								<tr>
								  <td class="text-center"></td>
								  <td class="text-center">{{number_format(($sumaTotalEnero - $presupEnero),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero) - ($presupEnero + $presupFebrero),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo) - ($presupEnero + $presupFebrero + $presupMarzo),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre),2,',','.')}}</td>
								  <td class="text-center">{{number_format(($sumaTotalEnero + $sumaTotalFebrero + $sumaTotalMarzo + $sumaTotalAbril + $sumaTotalMayo + $sumaTotalJunio + $sumaTotalJulio + $sumaTotalAgosto + $sumaTotalSeptiembre + $sumaTotalOctubre + $sumaTotalNoviembre + $sumaTotalDiciembre) - ($presupEnero + $presupFebrero + $presupMarzo + $presupAbril + $presupMayo + $presupJunio + $presupJulio + $presupAgosto + $presupSeptiembre + $presupOctubre + $presupNoviembre + $presupDiciembre),2,',','.')}}</td>
								</tr>


							</tbody>
						</table>

						<div class="form-horizontal">
							<h2> </h2>
						</div>

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
						</tr>
					</thead>
					<tbody>
						@foreach ($ventasMesIntl as $ventaIntl)
						<tr>
							<td class="text-center">{{$loop->iteration}}</td>
							<td class="text-center">{{$ventaIntl->centro_venta}}</td>
							<td class="text-center"><a href="{{url('comercial/FacturaIntl/'.$ventaIntl->numero)}}" target="_blank"><strong>{{$ventaIntl->numero}}</strong></a></td>
							<td class="text-center">{{$ventaIntl->fecha_emision}}</td>
							<td class="text-center"><a href="{{url('comercial/proformas/'.$ventaIntl->proforma)}}" target="_blank"><strong>{{$ventaIntl->proforma}}</strong></a></td>
							<td class="text-center">{{$ventaIntl->country}}</td>
							<td class="text-center">{{$ventaIntl->cliente}}</td>
							<td class="text-center">{{number_format((($ventaIntl->fob)),2,',','.')}}</td>
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
							<td class="text-center"><strong>{{number_format((($totalVentasMesIntl[0]->mesActual)),2,',','.')}}</strong></td>
						</tr>
					</tbody>
				</table>
					<!--end of 1st Table -->
					<h4>Nacional</h4>
								<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="50%" align="left">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">Cliente</th>
											<th class="text-center">NETO</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center">1</td>
											<td class="text-center">NOVAFOODS S.A.</td>
											@if (empty($cierreMesNovafoods[0]->mesActual))
											<td class="text-center" style="background-color: #FFD03B;"></td>
											@else
											<td class="text-center" style="background-color: #FFD03B;">{{number_format((($cierreMesNovafoods[0]->mesActual / $valorDolar)),2,',','.')}}</td>
											@endif
										</tr>
										<tr>
											<td class="text-center">2</td>
											<td class="text-center">WALMART</td>
											@if (empty($cierreMesWalmart[0]->mesActual))
											<td class="text-center" style="background-color: #FFD03B;"></td>
											@else
											<td class="text-center" style="background-color: #FFD03B;">{{number_format((($cierreMesWalmart[0]->mesActual / $valorDolar)),2,',','.')}}</td>
											@endif
										</tr>

										<tr>
											<td class="text-center">3</td>
											<td class="text-center">RENOVA FUNCTIONALS S.A.</td>
											@if (empty($cierreMesRenova[0]->mesActual))
											<td class="text-center" style="background-color: #FFD03B;"></td>
											@else
											<td class="text-center" style="background-color: #FFD03B;">{{number_format((($cierreMesRenova[0]->mesActual / $valorDolar)),2,',','.')}}</td>
											@endif
										</tr>

										<tr>
											<td class="text-center">4</td>
											<td class="text-center">MERCADO NACIONAL S.A.</td>
											@if (empty($cierreMesMercaNacional[0]->mesActual))
											<td class="text-center" style="background-color: #FFD03B;"></td>
											@else
											<td class="text-center" style="background-color: #FFD03B;">{{number_format((($cierreMesMercaNacional[0]->mesActual / $valorDolar)),2,',','.')}}</td>
											@endif
										</tr>
										@foreach ($cierreMesSumarca as $venta)
										<tr>
											<td class="text-center">{{$loop->iteration + 4}}</td>
											<td class="text-center">{{$venta->client}}</td>
											@if ($venta->mesActual == '')
											<td class="text-center" style="background-color: #FFD03B;">-</td>
											@else
											<td class="text-center" style="background-color: #FFD03B;">{{number_format((($venta->mesActual / $valorDolar)),2,',','.')}}</td>
											@endif
										</tr>
										@endforeach
										<tr>
											<td class="text-center"></td>
											<td class="text-center"><strong>TOTAL</strong></td>
											<td class="text-center"><strong>{{number_format((($totalVentasMesNac[0]->mesActual / $valorDolar)),2,',','.')}}</strong></td>
										</tr>
									</tbody>
								</table>

								<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="40%" align="right">
									<thead>
										<tr>
											<th class="text-center">Total Nacional</th>
											<th class="text-center">Total Intl.</th>
											<th class="text-center">Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-center">{{number_format((($totalVentasMesNac[0]->mesActual / $valorDolar)),2,',','.')}}</td>
											<td class="text-center">{{number_format((($totalVentasMesIntl[0]->mesActual)),2,',','.')}}</td>
											<td class="text-center">{{number_format(((($totalVentasMesNac[0]->mesActual / $valorDolar) + $totalVentasMesIntl[0]->mesActual)),2,',','.')}}</td>
										</tr>

									</tbody>
								</table>
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
<script src="{{asset('js/informes/cierreMes/cierreMesTotalChart.js')}}"></script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
