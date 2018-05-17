@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Mezclado</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarProduccionMezclado')}}">

				{{ csrf_field() }}

		        <h5>Datos</h5>

				<!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Numero:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text"  value="NUEVO" readonly>
					</div>
					<label class="control-label col-lg-1">Fecha:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm text-center" type="text" name="fecha" value="{{$fecha}}" readonly>
					</div>

				</div>
				<!-- /form-group -->

		        <!-- form-group -->
		        <div class="form-group">

		          <label class="control-label col-lg-1">Formula:</label>
				  <div class="col-lg-3">
		            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formulaID" v-model="formulaID" @change="updateList" required>
		              	<option value=""></option>
						<option v-for="formula in formulas" :value="formula.id">@{{formula.producto.descripcion}}</option>
		            </select>
		          </div>
				  <label class="control-label col-lg-1">Premezcla:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="text" name="premezcla" :value="premezcla" readonly>
				  </div>
				  <label class="control-label col-lg-1">Batch:</label>
				  <div class="col-lg-1">
					  <input class="form-control input-sm" type="number" min="1" step="1" name="cantBatch" v-model="cantBatch">
				  </div>
				  <div class="col-lg-1">
					  <button class="btn btn-sm btn-default" type="button" @click="calculate">Calcular</button>
				  </div>

		        </div>
		        <!-- /form-group -->
				<input class="form-control input-sm" type="hidden" name="formulaID" :value="formulaID" required>
				<input class="form-control input-sm" type="hidden" name="premezclaID" :value="premezclaID" required>
				<input class="form-control input-sm" type="hidden" name="nivelID" value="{{$nivel}}" required>

			</form>
			<!-- /form -->
	    </div>
	    <!-- /box-body -->

	    <!-- box-footer -->
	    <div class="box-footer">

      		<h5>Detalle</h5>

 		<!--<div style="overflow-y: scroll;max-height:200px;border:1px solid black;">-->
      <div>
        <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

          <thead>

            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">CxBatch</th>
              <th class="text-center">Nivel</th>
			  <th class="text-center">Total Batch</th>
            </tr>

          </thead>

          <tbody>
			  <tr v-if="items.length <= 0">
			  	<td class="text-center" colspan="6">Sin datos...</td>
			  </tr>
              <tr v-for="(item,key) in items">
                <td class="text-center">@{{key+1}}</td>
                <td class="text-center">@{{item.insumo.codigo}}</td>
                <td class="text-center">@{{item.insumo.descripcion}}</td>
                <td class="text-right">@{{item.cantxbatch}}</td>
                <td class="text-center">@{{item.nivel.descripcion}}</td>
                <td class="text-right">@{{item.totalBatch}}</td>
              </tr>

			<tr v-if="items.length > 0">
				<th class="text-right active" colspan="5">TOTAL:</th>
				<th class="text-right active">@{{totalBatch}}</th>
			</tr>
          </tbody>

        </table>

      </div>

    </div>
    <!-- /box-footer -->
	<!-- box-footer -->
	<div class="box-footer">
		<button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
	</div>
	<!-- /box-footer -->
  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var formulas = {!!$formulas!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/produccion/createPremezcla.js')}}"></script>
@endsection
