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
			<h4>Bodegas</h4>
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
				</div>
			</div>

			<div>

			<template v-for='columnas in estantes' >

				<div class="btn-group">

					<template v-for='posicion in columnas'>

						<button v-bind:class="statusClass(posicion.status_id)" class="custom btn btn-sm"   @click='selectedPos(posicion)'  type="button" name="button"><small>@{{posicion.columna +"-"+ posicion.estante}}</small></button>

					</template>

				</div>

				<br>

			</template>

			</div>
		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">

			<div class="row">
	          <div class=" col-sm-2">
	            <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

	                <tr>
	                  <th class="bg-gray text-right">id:</th>
	                  <td class="bg-gray text-right">@{{posicion.id}}</td>
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
	                  <td class="bg-gray text-right">@{{posicion.status_id}}</td>
	                </tr>

	            </table>
	          </div>

			  <!-- form-horizontal -->
			  <div class="form-horizontal col-sm-8">

				  <!-- form-group -->
				  <div class="form-group form-group-sm">

					  <label class="control-label col-lg-1">Condicion:</label>
					  <div class="col-lg-2">
						  <select :disabled="!selected" class="selectpicker" data-width="false" data-live-search="true" v-model="tipoCond" @change="getOpciones" data-style="btn-sm btn-default" name="condicion" required>
							  <option value="">Seleccione Condicion</option>
							  <option v-for="tipo in tiposCondicion" :value="tipo.id">@{{tipo.descripcion}}</option>
						  </select>

					  </div>

				  </div>
				  <!-- /form-group -->

				  <!-- form-group -->
				  <div class="form-group form-group-sm">
					  <label class="control-label col-lg-1">Opcion:</label>
					  <div class="col-lg-2">
						  <select :disabled="!tipoCond" class="selectpicker" data-width="false" data-live-search="true" v-model="opcion" data-style="btn-sm btn-default" name="opcion" required>
							  <option value="">Seleccione Opcion</option>
							  <option v-for="opc in opciones" :value="opc.id">@{{opc.descripcion}}</option>
						  </select>

					  </div>
				  </div>
				  <!-- /form-group -->

				  <!-- form-group -->
				  <div class="form-group form-group-sm">
					  <label class="control-label col-lg-1">Status:</label>
					  <div class="col-lg-2">
						  <select :disabled="!selected" class="selectpicker" data-width="false" data-live-search="true" v-model="status" data-style="btn-sm btn-default" name="opcion" required>
							  <option value="">Seleccione Status</option>
							  <option v-for="stat in statusAll" :value="stat.id">@{{stat.descripcion}}</option>
						  </select>

					  </div>
				  </div>
				  <!-- /form-group -->

				  <!-- form-group -->
				  <div class="form-group form-group-sm">
					  <div class="col-lg-1 col-sm-offset-3">
						  <button class="btn btn-sm btn-default"  :disabled="!selected" type="button" @click="storeData" name="button">Agregar</button>
					  </div>
				  </div>
				  <!-- /form-group -->

			  </div>
			  <!-- /form-horizontal -->
	        </div>


		</div>
		<!-- /box-body -->

	</div>
@endsection

@section('scripts')
	<script>
		bloques = {!!$bloques!!};
		tiposCondicion = {!!$tiposCondicion!!};
		statusAll = {!!$status!!}
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/Show.js')}}"></script>
@endsection
