@extends('layouts.masterOperaciones')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingreso Pallet</h4>
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

			<!-- form-horizontal -->
			<form class="form-horizontal" action="">

				<!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Bodega:</label>
                    <div class="col-lg-4">
                      <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodegaId" required>
                        <option value=""></option>
						@foreach ($bodegas as $bodega)
							<option value="{{$bodega->id}}">{{$bodega->descripcion}}</option>
						@endforeach

                      </select>
                    </div>

                    <label class="control-label col-lg-1">Pallet:</label>
                    <div class="col-lg-2">
						<input class="form-control input-sm" name="palletNum" type="number" v-model="palletNum" v-on:keyup.enter.prevent="getPallet" required>
                    </div>

                </div>
                <!-- /form-group -->

			</form>
			<!-- /form-horizontal -->

			<!-- tab-list -->
			<ul v-if="pallet" class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#info">Info</a></li>
			  <li><a data-toggle="tab" href="#detalles">Detalles</a></li>
			</ul>
			<!-- /tab-list -->

			<!-- tab-content -->
			<div class="tab-content">

				<!-- tab-panel -->
				<div id="info" class="tab-pane fade in active">

					<!-- box-body -->
					<div v-if="pallet" class="box-body">

						<div class="row">

							<div v-if="posicion" class="col-sm-2">
								<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

									<tr>
									  <th class="bg-gray text-right">Posicion:</th>
									  <td class="bg-gray text-right">@{{posicion.bloque+'-'+posicion.columna+'-'+posicion.estante}}</td>
									</tr>

									<tr>
									  <th class="bg-gray text-right">Rack:</th>
									  <td class="bg-gray text-right">@{{posicion.bloque}}</td>
									</tr>
									<tr>
									  <th class="bg-gray text-right">Columna:</th>
									  <td class="bg-gray text-right">@{{posicion.columna}}</td>
									</tr>
									<tr>
									  <th class="bg-gray text-right">Estante:</th>
									  <td class="bg-gray text-right">@{{posicion.estante}}</td>
									</tr>

									<tr>
									  <th class="bg-gray text-right">Status:</th>
									  <td class="bg-gray text-right">@{{posicion.status.descripcion}}</td>
									</tr>

									<tr>
										<th class="bg-gray text-right" colspan="2">
											<button form="insertPallet" class="btn btn-sm btn-default" type="submit" name="button">Ingresar pallet</button>
										</th>
									</tr>

								</table>
							</div>

							<div v-else class=" col-sm-2">
								<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

									<tr>
									  <th class="bg-gray text-right">Posicion:</th>
									  <td class="bg-gray text-right">No disponibles</td>
									</tr>

								</table>
							</div>

							<div class=" col-sm-8">

								<table v-show="pallet != ''" class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

									<thead>

										<tr>
											<th colspan="3" class="text-center">RESUMEN</th>
										</tr>
										<tr>
											<th class="text-center">PRODUCTO</th>
											<th class="text-center">CANTIDAD</th>
										</tr>

									</thead>

									<tbody>

										<tr v-for="detalle in pallet.detalleGroup">
											<td class="text-left">@{{detalle.descripcion}}</td>
											<td class="text-right">@{{detalle.cantidad}}</td>
										</tr>

									</tbody>

								</table>

							</div>

						</div>
						<form id="insertPallet" method="post" action="{{route('guardarPalletEnPosicion')}}">
							{{ csrf_field() }}
							<input type="hidden" name="posicion" :value="posicion.id" required>
							<input type="hidden" name="pallet" :value="pallet.id" required>

						</form>
					</div>
					<!-- /box-body -->
				</div>
				<!-- /tab-panel -->

				<!-- tab-panel -->
				<div id="detalles" class="tab-pane fade in">

					<!-- box-body -->
					<div v-if="pallet" class="box-body">

						<div class="row">

							<div class=" col-sm-8">

								<table v-show="pallet != ''" class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

									<thead>

										<tr>
											<th class="text-center">CODIGO</th>
											<th class="text-center">PRODUCTO</th>
											<th class="text-center">PROCEDENCIA</th>
											<th class="text-center">LOTE</th>
											<th class="text-center">F. VENC.</th>
											<th class="text-center">CANTIDAD</th>
										</tr>

									</thead>

									<tbody>

										<tr v-for="detalle in pallet.detalles">
											<td class="text-left">@{{detalle.producto.codigo}}</td>
											<td class="text-left">@{{detalle.producto.descripcion}}</td>
											<td class="text-left">@{{detalle.tipo.descripcion}}</td>
											<td v-if="detalle.ingreso" class="text-center">@{{detalle.ingreso.lote}}</td>
											<td v-else class="text-left"></td>
											<td class="text-center">@{{detalle.fecha_venc}}</td>
											<td class="text-right">@{{detalle.cantidad}}</td>
										</tr>

									</tbody>

								</table>

							</div>

						</div>

					</div>
					<!-- /box-body -->

				</div>
				<!-- /tab-panel -->

			</div>
			<!-- /tab-content -->

		</div>

	</div>
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/ingresoPallet.js')}}"></script>
@endsection
