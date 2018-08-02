@extends('layouts.masterOperaciones')

@section('content')
<style>
.custom {
	margin: 0px;
	padding: 0px;
	width: 30px !important;
	height: 30px !important;
}
</style>
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>{{$bodega->descripcion}}</h4>
		</div>

		<!-- box-body -->
		<div class="box-body">

			<div class="form-horizontal">

				<div class="form-group">

					<label class="control-label col-sm-1">Rack:</label>
					<div class="col-sm-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" v-model="bloque" @change="changeBloque" data-style="btn-sm btn-default" name="bloque" required>
							<option value="">Seleccione Bloque</option>
							<option v-for="(bloque,key) in bloques" :value="key">@{{'Rack #' + (key+1) }}</option>
						</select>
					</div>
					<div class="col-sm-1">
						<button type="button"  class="btn btn-default" data-toggle="modal" data-target="#findPalletPos">Buscar Pallet</button>
					</div>

					<div class="col-sm-6">
						<label class="control-label"><span class="label label-success"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Disponible</label>
						<label class="control-label"><span class="label label-danger"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Ocupado</label>
						<label class="control-label"><span class="label label-warning"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Reservado</label>
						<label class="control-label"><span class="label label-primary"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Bloq.</label>
						<label class="control-label"><span class="label label-default"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Inactiva</label>

					</div>
				</div>

			</div>

			<div class="col-sm-12">

			<template v-for='columnas in estantes' >

				<div class="btn-group">

					<template v-for='posicion in columnas'>

						<button v-if="posicion.status_id != 1" v-bind:class="statusClass(posicion.status_id)" class="custom btn btn-sm"   @click='selectedPos(posicion)'  type="button" name="button" :disabled="posicion.status_id == 1">@{{posicion.columna +"-"+ posicion.estante}}</button>

						<button v-if="posicion.status_id == 1" v-bind:class="statusClass(posicion.status_id)" class="custom btn btn-sm"   @click='selectedPos(posicion)'  type="button" name="button" :disabled="posicion.status_id == 1">##</button>

					</template>

				</div>

				<br>

			</template>

			</div>
		</div>
		<!-- /box-body -->

		<!-- tab-list -->
		<ul v-if="selected" class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#info">Info</a></li>
		  <li><a data-toggle="tab" href="#detalles">Detalles</a></li>
		</ul>
		<!-- /tab-list -->

		<!-- tab-content -->
		<div class="tab-content">

			<!-- tab-panel -->
  			<div id="info" class="tab-pane fade in active">

				<!-- box-body -->
				<div v-if="selected" class="box-body">

					<div class="row">

						<div class=" col-sm-3">
							<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							    <tr>
							      <th class="bg-gray text-right">Posicion:</th>
							      <td class="bg-gray text-right">@{{posicion.bloque+'-'+posicion.columna+'-'+posicion.estante}}</td>
							    </tr>

							    <tr>
							      <th class="bg-gray text-right">Status:</th>
							      <td class="bg-gray text-right">@{{posicion.status.descripcion}}</td>
							    </tr>

							    <tr>
							      <th class="bg-gray text-right">Pallet:</th>
							      <td class="bg-gray text-right">@{{ pallet.numero ? pallet.numero : 'Vacio'}}</td>
							    </tr>
							    <tr>
							      <th class="bg-gray text-right">Bloqueo:</th>
							      <td class="bg-gray text-right">
									<div class="btn-group" role="group" aria-label="...">
									<button class="btn btn-sm btn-default" type="button" name="button" @click="unBlockPosition">Desbloq.</button>
									<button class="btn btn-sm btn-default" type="button" name="button" @click="blockPosition">Bloq.</button>
									</div>
								  </td>
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
										<td class="text-left">@{{detalle.producto.descripcion}}</td>
										<td class="text-right">@{{detalle.cantidad}}</td>
									</tr>

								</tbody>

				            </table>

						</div>

						<div v-if="pallet != ''" class="col-sm-12">

							<form id="addItemToPallet" style="display:inline" :action="addItemToPalletURL" method="get">
							</form>
							<form id="removeItemFromPallet" style="display:inline" :action="crearEgrManualDePalletURL" method="get">
							</form>
							<div class="btn-group align-center" role="group" aria-label="...">

									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#trasladoPallet">Traslado de Pallet</button>

									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#moveItemBetweenPallet">Mover Producto a Pallet</button>

									<input form="addItemToPallet" type="hidden" name="numero" :value="pallet.numero">
									<button form="addItemToPallet" type="submit" class="btn btn-default">Ingresar</button>

									<input form="removeItemFromPallet" type="hidden" name="numero" :value="pallet.numero">
									<button form="removeItemFromPallet" type="submit" class="btn btn-default">Egresar</button>
							</div>
						</div>

			        </div>

				</div>
				<!-- /box-body -->
			</div>
			<!-- /tab-panel -->

			<!-- tab-panel -->
  			<div id="detalles" class="tab-pane fade in">

				<!-- box-body -->
				<div v-if="selected" class="box-body">

					<div class="row">

					 	<div class=" col-sm-10">

							<table v-show="pallet != ''" class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

								<thead>

									<tr>
										<th class="text-center">CODIGO</th>
										<th class="text-center">PRODUCTO</th>
										<th class="text-center">PROCEDENCIA</th>
										<th class="text-center">NUMERO</th>
										<th class="text-center">FECHA. ING.</th>
										<th class="text-center">FECHA. VENC.</th>
										<th class="text-center">CANTIDAD</th>
									</tr>

								</thead>

								<tbody>

									<tr v-for="detalle in pallet.detalles">
										<td class="text-left">@{{detalle.producto.codigo}}</td>
										<td class="text-left">@{{detalle.producto.descripcion}}</td>
										<td class="text-left">@{{detalle.tipo.descripcion}}</td>
										<td v-if="detalle.ingreso" class="text-center">
											<a :href="'/bodega/ingreso/' + detalle.ingreso.numero" target="_blank">
											@{{detalle.ingreso.numero}}</a>
										</td>
										<td v-else class="text-left"></td>
										<td class="text-center">
											@{{detalle.fecha_ing}}</td>
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

		<!-- box-footer -->
		<div class="box-footer">

			<ul>
				<li><a href="{{route('reporteBodega')}}">Saldos Bodega</a></li>
				{{--<li><a href="{{route('reporteBodegaPT')}}">Saldos Producto Terminado</a></li>--}}
				{{--<li><a href="">Saldos Producto Insumos</a></li>--}}
				{{--<li><a href="">Saldos Producto Premezcla</a></li>--}}
				{{--<li><a href="">Buscar Producto</a></li>--}}
			</ul>

		</div>
		<!-- /box-footer -->

	</div>

	@include('bodega.bodega.moveItemBetweenPalletTab')
	@include('bodega.bodega.trasladoPalletTab')
	@include('bodega.bodega.findPalletPosTab')


@endsection

@section('scripts')
	<script>
		bodega = {!!$bodega!!};
		bloques = {!!$bloques!!};
		bodegaConsultURL = "{!!route('apiConsultarBodega')!!}";
		bloquearPosURL = "{!!route('apiBloqPosBodega')!!}";
		desbloquearPosURL = "{!!route('apiDesBloqPosBodega')!!}";
		addItemToPalletURL = "{!!route('agregarItemPallet')!!}";
		crearEgrManualDePalletURL = "{!!route('crearEgrManualDePallet')!!}";
		findPalletPosURL = "{!!route('buscarPosConPallet')!!}"
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/consult.js')}}"></script>
	<script src="{{asset('js/bodega/trasladoPallet.js')}}"></script>
	<script src="{{asset('js/bodega/moveItemBetweenPallet.js')}}"></script>
	<script src="{{asset('js/bodega/findPalletPos.js')}}"></script>
@endsection
