<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Total de Ventas</title>
  </head>

 <body>
				<!-- 1st Table -->
				<h4>Internacional</h4>
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Cliente</th>
							<th>{{$mesPasado}}</th>
							<th>{{$mesActual}}</th>
							<th>Index YA</th>
              <th>#</th>
              <th>Acum {{$mesPasado}} {{$lastYearSelected}}</th>
              <th>Acum {{$mesActual}} {{$yearSelected}}</th>
              <th>Index YA</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($ventaMesIntl as $venta)
						@if($venta->acumuladoAnterior == '' && $venta->acumuladoActual == '')

						@else
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{$venta->client}} ({{$venta->country}})</td>
							@if ($venta->mesAnterior == '')
							<td>-</td>
							@else
							<td>{{number_format(($venta->mesAnterior),2,',','.')}}</td>
							@endif

							@if ($venta->mesActual == '')
							<td style="background-color: #FFD03B;">-</td>
							@else
							<td style="background-color: #FFD03B;">{{number_format(($venta->mesActual),2,',','.')}}</td>
							@endif

							@if ($venta->mesAnterior == '' || $venta->mesActual == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->mesActual / $venta->mesAnterior * 100),2,',','.')}}%</td>
							@endif
              <td> </td>
              @if($venta->acumuladoAnterior == '')
              <td>-</td>
              @else
              <td>{{number_format(($venta->acumuladoAnterior),2,',','.')}}</td>
              @endif

              @if($venta->acumuladoActual == '')
              <td style="background-color: #FFD03B;">-</td>
              @else
              <td style="background-color: #FFD03B;">{{number_format(($venta->acumuladoActual),2,',','.')}}</td>
              @endif

              @if ($venta->acumuladoActual  == '' || $venta->acumuladoAnterior == '')
              <td style="background-color: #002060; color: #FFFFFF;">-</td>
              @else
              <td style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->acumuladoActual / $venta->acumuladoAnterior * 100),2,',','.')}}%</td>
              @endif
            </tr>
						@endif
						@endforeach
						<tr>
							<td style="background-color: #002060; color: #FFFFFF;"></td>
							<td style="background-color: #002060; color: #FFFFFF;"><strong>Total</strong></td>
							@if ($sumaAnterior == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAnterior),2,',','.')}}</td>
							@endif
							@if ($sumaTotal == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotal),2,',','.')}}</td>
							@endif
							@if ($sumaTotal == '' || $sumaAnterior == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotal / $sumaAnterior * 100),2,',','.')}}%</td>
							@endif
							<td style="background-color: #002060; color: #FFFFFF;"></td>
							@if ($sumaAcumuladoAnterior == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoAnterior),2,',','.')}}</td>
							@endif
							@if ($sumaAcumuladoTotal == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotal),2,',','.')}}</td>
							@endif
							@if ($sumaAcumuladoTotal == '' || $sumaAcumuladoAnterior == '')
							<td style="background-color: #002060; color: #FFFFFF;">-</td>
							@else
							<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotal / $sumaAcumuladoAnterior * 100),2,',','.')}}%</td>
							@endif
						</tr>
					</tbody>
				</table>

		<h4>Nacional</h4>
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>Cliente</th>
								<th>{{$mesPasado}}</th>
								<th>{{$mesActual}}</th>
								<th>Index YA</th>
                <th>#</th>
                <th>Acum {{$mesPasado}} {{$lastYearSelected}}</th>
                <th>Acum {{$mesActual}} {{$yearSelected}}</th>
                <th>Index YA</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>NOVAFOODS S.A.</td>
								@if (empty($ventaMesNovafoods[0]->mesAnterior))
								<td></td>
								@else
								<td>{{number_format((($ventaMesNovafoods[0]->mesAnterior / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesNovafoods[0]->mesActual))
								<td style="background-color: #FFD03B;"></td>
								@else
								<td style="background-color: #FFD03B;">{{number_format((($ventaMesNovafoods[0]->mesActual / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesNovafoods[0]->mesActual) || empty($ventaMesNovafoods[0]->mesAnterior))
								<td style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesNovafoods[0]->mesActual / $ventaMesNovafoods[0]->mesAnterior * 100),2,',','.')}}%</td>
								@endif
                <td></td>
      					@if (empty($ventaMesNovafoods[0]->acumuladoAnterior))
      					<td></td>
      					@else
      					<td>{{number_format((($ventaMesNovafoods[0]->acumuladoAnterior / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesNovafoods[0]->acumuladoActual))
      					<td style="background-color: #FFD03B;"></td>
      					@else
      					<td style="background-color: #FFD03B;">{{number_format((($ventaMesNovafoods[0]->acumuladoActual / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesNovafoods[0]->acumuladoActual) || empty($ventaMesNovafoods[0]->acumuladoAnterior))
      					<td style="background-color: #002060; color: #FFFFFF;">-</td>
      					@else
      					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesNovafoods[0]->acumuladoActual / $ventaMesNovafoods[0]->acumuladoAnterior * 100),2,',','.')}}%</td>
      					@endif
							</tr>
              <tr>
								<td class="text-center">2</td>
								<td class="text-center">WALMART</td>
								@if (empty($ventaMesWalmart[0]->mesAnterior))
								<td class="text-center"></td>
								@else
								<td class="text-center">{{number_format((($ventaMesWalmart[0]->mesAnterior / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesWalmart[0]->mesActual))
								<td class="text-center" style="background-color: #FFD03B;"></td>
								@else
								<td class="text-center" style="background-color: #FFD03B;">{{number_format((($ventaMesWalmart[0]->mesActual / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesWalmart[0]->mesActual) || empty($ventaMesWalmart[0]->mesAnterior))
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesWalmart[0]->mesActual / $ventaMesWalmart[0]->mesAnterior * 100),2,',','.')}}%</td>
								@endif
                <td class="text-center"></td>
                @if (empty($ventaMesWalmart[0]->acumuladoAnterior))
                <td class="text-center"></td>
                @else
                <td class="text-center">{{number_format((($ventaMesWalmart[0]->acumuladoAnterior / $valorDolar)),2,',','.')}}</td>
                @endif
                @if (empty($ventaMesWalmart[0]->acumuladoActual))
                <td class="text-center" style="background-color: #FFD03B;"></td>
                @else
                <td class="text-center" style="background-color: #FFD03B;">{{number_format((($ventaMesWalmart[0]->acumuladoActual / $valorDolar)),2,',','.')}}</td>
                @endif
                @if (empty($ventaMesWalmart[0]->acumuladoActual) || empty($ventaMesWalmart[0]->acumuladoAnterior))
                <td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
                @else
                <td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesWalmart[0]->acumuladoActual / $ventaMesWalmart[0]->acumuladoAnterior * 100),2,',','.')}}%</td>
                @endif
							</tr>

							<tr>
								<td class="text-center">3</td>
								<td class="text-center">RENOVA FUNCTIONALS S.A.</td>
								@if (empty($ventaMesRenova[0]->mesAnterior))
								<td class="text-center"></td>
								@else
								<td class="text-center">{{number_format((($ventaMesRenova[0]->mesAnterior / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesRenova[0]->mesActual))
								<td class="text-center" style="background-color: #FFD03B;"></td>
								@else
								<td class="text-center" style="background-color: #FFD03B;">{{number_format((($ventaMesRenova[0]->mesActual / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesRenova[0]->mesActual) || empty($ventaMesRenova[0]->mesAnterior))
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesRenova[0]->mesActual / $ventaMesRenova[0]->mesAnterior * 100),2,',','.')}}%</td>
								@endif
                <td></td>
      					@if (empty($ventaMesRenova[0]->acumuladoAnterior))
      					<td></td>
      					@else
      					<td>{{number_format((($ventaMesRenova[0]->acumuladoAnterior / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesRenova[0]->acumuladoActual))
      					<td style="background-color: #FFD03B;"></td>
      					@else
      					<td style="background-color: #FFD03B;">{{number_format((($ventaMesRenova[0]->acumuladoActual / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesRenova[0]->acumuladoActual) || empty($ventaMesRenova[0]->acumuladoAnterior))
      					<td style="background-color: #002060; color: #FFFFFF;">-</td>
      					@else
      					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesRenova[0]->acumuladoActual / $ventaMesRenova[0]->acumuladoAnterior * 100),2,',','.')}}%</td>
      					@endif
							</tr>

							<tr>
								<td class="text-center">4</td>
								<td class="text-center">MERCADO NACIONAL S.A.</td>
								@if (empty($ventaMesMercaNacional[0]->mesAnterior))
								<td class="text-center"></td>
								@else
								<td class="text-center">{{number_format((($ventaMesMercaNacional[0]->mesAnterior / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesMercaNacional[0]->mesActual))
								<td class="text-center" style="background-color: #FFD03B;"></td>
								@else
								<td class="text-center" style="background-color: #FFD03B;">{{number_format((($ventaMesMercaNacional[0]->mesActual / $valorDolar)),2,',','.')}}</td>
								@endif
								@if (empty($ventaMesMercaNacional[0]->mesActual) || empty($ventaMesMercaNacional[0]->mesAnterior))
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td class="text-center" style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesMercaNacional[0]->mesActual / $ventaMesMercaNacional[0]->mesAnterior * 100),2,',','.')}}%</td>
								@endif
                <td></td>
      					@if (empty($ventaMesMercaNacional[0]->acumuladoAnterior))
      					<td></td>
      					@else
      					<td>{{number_format((($ventaMesMercaNacional[0]->acumuladoAnterior / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesMercaNacional[0]->acumuladoActual))
      					<td style="background-color: #FFD03B;"></td>
      					@else
      					<td style="background-color: #FFD03B;">{{number_format((($ventaMesMercaNacional[0]->acumuladoActual / $valorDolar)),2,',','.')}}</td>
      					@endif
      					@if (empty($ventaMesMercaNacional[0]->acumuladoActual) || empty($ventaMesMercaNacional[0]->acumuladoAnterior))
      					<td style="background-color: #002060; color: #FFFFFF;">-</td>
      					@else
      					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($ventaMesMercaNacional[0]->acumuladoActual / $ventaMesMercaNacional[0]->acumuladoAnterior * 100),2,',','.')}}%</td>
      					@endif
							</tr>
							@foreach ($ventaMesSumarca as $venta)
							<tr>
								<td>{{$loop->iteration + 4}}</td>
								<td>{{$venta->client}}</td>
								@if ($venta->mesAnterior == '')
								<td>-</td>
								@else
								<td>{{number_format((($venta->mesAnterior / $valorDolar)),2,',','.')}}</td>
								@endif

								@if ($venta->mesActual == '')
								<td style="background-color: #FFD03B;">-</td>
								@else
								<td style="background-color: #FFD03B;">{{number_format((($venta->mesActual / $valorDolar)),2,',','.')}}</td>
								@endif

								@if ($venta->mesAnterior == '' || $venta->mesActual == '')
								<td style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->mesActual / $venta->mesAnterior * 100),2,',','.')}}%</td>
								@endif
                <td></td>
      					@if($venta->acumuladoAnterior == '')
      					<td>-</td>
      					@else
      					<td>{{number_format(($venta->acumuladoAnterior / $valorDolar),2,',','.')}}</td>
      					@endif

      					@if($venta->acumuladoActual == '')
      					<td style="background-color: #FFD03B;">-</td>
      					@else
      					<td style="background-color: #FFD03B;">{{number_format(($venta->acumuladoActual / $valorDolar),2,',','.')}}</td>
      					@endif

      					@if ($venta->acumuladoActual  == '' || $venta->acumuladoAnterior == '')
      					<td style="background-color: #002060; color: #FFFFFF;">-</td>
      					@else
      					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($venta->acumuladoActual / $venta->acumuladoAnterior * 100),2,',','.')}}%</td>
      					@endif
							</tr>
							@endforeach
							<tr>
								<td style="background-color: #002060; color: #FFFFFF;"></td>
								<td style="background-color: #002060; color: #FFFFFF;"><strong>Total</strong></td>
								@if ($sumaAnteriorNac == '')
								<td style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td style="background-color: #002060; color: #FFFFFF;">{{number_format((($sumaAnteriorNac)),2,',','.')}}</td>
								@endif
								@if ($sumaTotalNac == '')
								<td style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td style="background-color: #002060; color: #FFFFFF;">{{number_format((($sumaTotalNac)),2,',','.')}}</td>
								@endif
								@if ($sumaTotalNac == '' || $sumaAnteriorNac == '')
								<td style="background-color: #002060; color: #FFFFFF;">-</td>
								@else
								<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotalNac / $sumaAnteriorNac * 100),2,',','.')}}%</td>
								@endif
                <td style="background-color: #002060; color: #FFFFFF;"></td>
                @if ($sumaAcumuladoAnteriorNac == '')
                <td style="background-color: #002060; color: #FFFFFF;">-</td>
                @else
                <td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoAnteriorNac),2,',','.')}}</td>
                @endif
                @if ($sumaAcumuladoTotalNac == '')
                <td style="background-color: #002060; color: #FFFFFF;">-</td>
                @else
                <td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotalNac),2,',','.')}}</td>
                @endif
                @if ($sumaAcumuladoTotalNac == '' || $sumaAcumuladoAnteriorNac == '')
                <td style="background-color: #002060; color: #FFFFFF;">-</td>
                @else
                <td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotalNac / $sumaAcumuladoAnteriorNac * 100),2,',','.')}}%</td>
                @endif
							</tr>

						</tbody>
					</table>
		<!-- /table -->

		<h4>Resumen</h4>
		<table>
			<thead>
				<tr>
					<th>#</th>
          <th></th>
					<th>{{$mesPasado}}</th>
					<th>{{$mesActual}}</th>
					<th>Index YA</th>
          <th></th>
          <th>Acum {{$mesPasado}} {{$lastYearSelected}}</th>
          <th>Acum {{$mesActual}} {{$yearSelected}}</th>
          <th>Index YA</th>
				</tr>
			</thead>
			<tbody>
				<tr>
          <td></td>
					<td><strong>Total Internacional</strong></td>
					@if ($sumaAnterior == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaAnterior),2,',','.')}}</td>
					@endif
					@if ($sumaTotal == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaTotal),2,',','.')}}</td>
					@endif
					@if ($sumaTotal == '' || $sumaAnterior == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaTotal / $sumaAnterior * 100),2,',','.')}}%</td>
					@endif
          <td></td>
          @if ($sumaAcumuladoAnterior == '')
          <td>-</td>
          @else
          <td>{{number_format(($sumaAcumuladoAnterior),2,',','.')}}</td>
          @endif
          @if ($sumaAcumuladoTotal == '')
          <td>-</td>
          @else
          <td>{{number_format(($sumaAcumuladoTotal),2,',','.')}}</td>
          @endif
          @if ($sumaAcumuladoTotal == '' || $sumaAcumuladoAnterior == '')
          <td>-</td>
          @else
          <td>{{number_format(($sumaAcumuladoTotal / $sumaAcumuladoAnterior * 100),2,',','.')}}%</td>
          @endif
				</tr>
				<tr>
          <td></td>
					<td><strong>Total Nacional</strong></td>
					@if ($sumaAnteriorNac == '')
					<td>-</td>
					@else
					<td>{{number_format((($sumaAnteriorNac)),2,',','.')}}</td>
					@endif
					@if ($sumaTotalNac == '')
					<td>-</td>
					@else
					<td>{{number_format((($sumaTotalNac)),2,',','.')}}</td>
					@endif
					@if ($sumaTotalNac == '' || $sumaAnteriorNac == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaTotalNac / $sumaAnteriorNac * 100),2,',','.')}}%</td>
					@endif
          <td></td>
					@if ($sumaAcumuladoAnteriorNac == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaAcumuladoAnteriorNac),2,',','.')}}</td>
					@endif
					@if ($sumaAcumuladoTotalNac == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaAcumuladoTotalNac),2,',','.')}}</td>
					@endif
					@if ($sumaAcumuladoTotalNac == '' || $sumaAcumuladoAnteriorNac == '')
					<td>-</td>
					@else
					<td>{{number_format(($sumaAcumuladoTotalNac / $sumaAcumuladoAnteriorNac * 100),2,',','.')}}%</td>
					@endif
				</tr>
				<tr>
          <td></td>
					<td style="background-color: #002060; color: #FFFFFF;"><strong>Total</strong></td>
					@if ($sumaAcumuladoAnteriorNac == '')
					<td style="background-color: #002060; color: #FFFFFF;">-</td>
					@else
					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAnterior + $sumaAnteriorNac),2,',','.')}}</td>
					@endif
					@if ($sumaAcumuladoTotalNac == '')
					<td style="background-color: #002060; color: #FFFFFF;">-</td>
					@else
					<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaTotal + $sumaTotalNac),2,',','.')}}</td>
					@endif
					@if ($sumaAcumuladoTotalNac == '' || $sumaAcumuladoAnteriorNac == '')
					<td style="background-color: #002060; color: #FFFFFF;">-</td>
					@else
					<td style="background-color: #002060; color: #FFFFFF;">{{number_format((($sumaTotal + $sumaTotalNac) * 100 / ($sumaAnterior + $sumaAnteriorNac)),2,',','.') }}%</td>
					@endif
          <td style="background-color: #002060; color: #FFFFFF;"></td>
  				@if ($sumaAcumuladoAnteriorNac == '')
  				<td style="background-color: #002060; color: #FFFFFF;">-</td>
  				@else
  				<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoAnteriorNac + $sumaAcumuladoAnterior),2,',','.')}}</td>
  				@endif
  				@if ($sumaAcumuladoTotalNac == '')
  				<td style="background-color: #002060; color: #FFFFFF;">-</td>
  				@else
  				<td style="background-color: #002060; color: #FFFFFF;">{{number_format(($sumaAcumuladoTotalNac + $sumaAcumuladoTotal),2,',','.')}}</td>
  				@endif
  				@if ($sumaAcumuladoTotalNac == '' || $sumaAcumuladoAnteriorNac == '')
  				<td style="background-color: #002060; color: #FFFFFF;">-</td>
  				@else
  				<td style="background-color: #002060; color: #FFFFFF;">{{number_format((($sumaAcumuladoTotalNac + $sumaAcumuladoTotal) * 100 / ($sumaAcumuladoAnteriorNac + $sumaAcumuladoAnterior)),2,',','.') }}%</td>
  				@endif
			</tr>
			</tbody>
		</table>

					</div>
			</div>
		</body>
	</html>
