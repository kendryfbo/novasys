	@extends('layouts.masterInforme')

	@section('content')
		<!-- box -->
		<div id="vue-app" class="box box-solid box-default">
			<!-- box-header -->
			<div class="box-header text-center">
				<h4>Reporte Contenedor por Cliente Mensual</h4>
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
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="dateSelected" required>
								<option value="{{$currentYear - 1}}">{{$currentYear - 1}}</option>
								<option value="{{$currentYear}}" selected>{{$currentYear}}</option>
								<option value="{{$currentYear + 1}}">{{$currentYear + 1}}</option>
							</select>
						</div>

						<div class="col-sm-2">
							<button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
							<button form="clearInput" class="btn btn-sm btn-info" type="submit">Limpiar</button>
						</div>

					</div>
					<!-- /form-group -->
				</form>
				<!-- /form -->
				<hr>
				<!-- 1st Table -->
				@if (empty($contenedoresPorCliente))

				@else
				<h4 align="center">Año  </h4>
				<table class="table-hover table-bordered table-custom table-condensed display nowrap compact" data-page-length='5' width="100%" align="center">
								<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">CLIENTE</th>
											<th class="text-center">ENERO</th>
											<th class="text-center">FEBRERO</th>
											<th class="text-center">MARZO</th>
											<th class="text-center">ABRIL</th>
											<th class="text-center">MAYO</th>
											<th class="text-center">JUNIO</th>
											<th class="text-center">JULIO</th>
											<th class="text-center">AGOSTO</th>
											<th class="text-center">SEPTIEMBRE</th>
											<th class="text-center">OCTUBRE</th>
											<th class="text-center">NOVIEMBRE</th>
											<th class="text-center">DICIEMBRE</th>
											<th class="text-center">TEU20</th>
											<th class="text-center">Index YA</th>
										</tr>
								</thead>
									<tbody>
								@foreach ($contenedoresPorCliente as $contenedores)
										<tr>
											<td class="text-center">{{$loop->iteration}}</td>
											<td class="text-center">{{$contenedores->cliente}}</td>
											@if (empty($contenedores->mesEnero))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesEnero <= '33')
												<td class="text-center" style="background-color: #55FF33;">20</td>
												@else
												<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesFebrero))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesFebrero <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesMarzo))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesMarzo <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesAbril))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesAbril <= '33')
												<td class="text-center" style="background-color: #55FF33;">20</td>
												@else
												<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesMayo))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesMayo <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesJunio))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesJunio <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesJulio))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesJulio <= '33')
												<td class="text-center" style="background-color: #55FF33;">20</td>
												@else
												<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesAgosto))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesAgosto <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesSeptiembre))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesSeptiembre <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesOctubre))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesOctubre <= '33')
												<td class="text-center" style="background-color: #55FF33;">20</td>
												@else
												<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesNoviembre))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesNoviembre <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->mesDiciembre))
													<td class="text-center">-</td>
													@elseif ($contenedores->mesDiciembre <= '33')
													<td class="text-center" style="background-color: #55FF33;">20</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">40</td>
											@endif
											@if (empty($contenedores->totalYearSelected))
													<td class="text-center">-</td>
													@else
													<td class="text-center" style="background-color: #55FF33;">{{number_format(($contenedores->totalYearSelected),1,',','.')}}</td>
											@endif

											@if (empty($contenedores->totalYearSelected && $contenedores->totalLastYear))
													<td class="text-center" rowspan="2">-</td>
													@else
													<td class="text-center" rowspan="2" style="background-color: #000080; color: #FFFFFF;">{{number_format(($contenedores->totalYearSelected / $contenedores->totalLastYear * 100),1,',','.')}}%</td>
											@endif
										</tr>
										<tr style="border-bottom-style: solid;">
											<td class="text-center"></td>
											<td class="text-center">{{$dateSelected - 1}}</td>
											@if (empty($contenedores->mesEneroAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesEneroAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesFebreroAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesFebreroAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesMarzoAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesMarzoAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesAbrilAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesAbrilAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesMayoAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesMayoAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesJunioAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesJunioAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesJulioAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesJulioAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesAgostoAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesAgostoAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesSeptiembreAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesSeptiembreAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesOctubreAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesOctubreAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesNoviembreAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesNoviembreAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->mesDiciembreAnt))
												<td class="text-center">-</td>
												@elseif ($contenedores->mesDiciembreAnt <= '33')
												<td class="text-center" style="background-color: #FFE333;">20</td>
												@else
												<td class="text-center" style="background-color: #FFE333;">40</td>
											@endif
											@if (empty($contenedores->totalLastYear))
													<td class="text-center">-</td>
													@else
													<td class="text-center" style="background-color: #FFE333;">{{number_format(($contenedores->totalLastYear),1,',','.')}}</td>
											@endif
										</tr>
								@endforeach
									</tbody>
							</table>
					 @endif
						</div>
			@endsection

			@section('scripts')
			<script src="{{asset('js/customDataTable.js')}}"></script>
			@endsection
