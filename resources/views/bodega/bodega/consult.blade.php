@extends('layouts.masterOperaciones')

@section('content')
<style>
.custom {
width: 50px !important;
}
</style>
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Bodega {{$bodega->descripcion}}</h4>
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

						<button v-bind:class="statusClass(posicion.status_id)" class="custom btn btn-sm"   @click='selectedPos(posicion)'  type="button" name="button">@{{posicion.columna +"-"+ posicion.estante}}</button>

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
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/consult.js')}}"></script>
@endsection
