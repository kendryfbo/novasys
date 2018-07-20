@extends('layouts.masterOperaciones')

@section('content')
<style>
.custom {
	margin: 0px;
	padding: 0px;
	width: 30px !important;
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

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Rack:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="false" data-live-search="true" v-model="bloque" @change="changeBloque" data-style="btn-sm btn-default" name="bloque" required>
							<option value="">Seleccione Bloque</option>
							<option v-for="(bloque,key) in bloques" :value="key">@{{'Rack #' + (key+1) }}</option>
						</select>

					</div>

					<label class="control-label col-lg-2"><span class="label label-success"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Disponible</label>
					<label class="control-label col-lg-2"><span class="label label-danger"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Ocupado</label>
					<label class="control-label col-lg-2"><span class="label label-warning"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Reservado</label>
					<label class="control-label col-lg-2"><span class="label label-default"><i class="fa fa-info-circle" aria-hidden="true"></i></span> Bloqueado</label>
				</div>
				<div class="form-group form-group-sm">


				</div>
			</div>

			<div>

			<template v-for='columnas in estantes' >

				<div class="btn-group">

					<template v-for='posicion in columnas'>

						<button v-bind:class="statusClass(posicion.status_id)" class="custom btn btn-sm"   @click='selectedPos(posicion)'  type="button" name="button">@{{posicion.columna +"-"+ posicion.estante}}</button>

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

						<div class=" col-sm-2">
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
							      <th class="bg-gray text-right">Pallet:</th>
							      <td class="bg-gray text-right">@{{ pallet.numero ? pallet.numero : 'Vacio'}}</td>
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

						<div v-if="pallet != ''" class="col-lg-12">
							<div class="btn-group align-center" role="group" aria-label="...">
								<button type="button" class="btn btn-default" data-toggle="modal" data-target="#trasladoPallet">Traslado de Pallet</button>

								<form class="" style="display:inline" :action="addItemToPalletURL" method="get">
									<input type="hidden" name="numero" :value="pallet.numero">
									<button type="submit" class="btn btn-default">Agregar Producto</button>
								</form>
								<button type="button" class="btn btn-default">Egreso Manual</button>
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
				<li><a href="{{route('verStockBodegaPT', ['bodega' => $bodega->id])}}">Saldos Producto Terminado</a></li>
				<li><a href="">Saldos Producto Insumos</a></li>
				<li><a href="">Saldos Producto Premezcla</a></li>
				<li><a href="">Buscar Producto</a></li>
			</ul>

		</div>
		<!-- /box-footer -->

	</div>

	@include('bodega.bodega.trasladoPalletTab')


@endsection

@section('scripts')
	<script>
		bloques = {!!$bloques!!};
		addItemToPalletURL = "{!!route('agregarItemPallet')!!}";
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/consult.js')}}"></script>
	<script src="{{asset('js/bodega/trasladoPallet.js')}}"></script>
@endsection
