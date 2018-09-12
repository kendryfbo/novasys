@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Verificar Existencia Orden Egreso</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal" method="get" action="">

				{{ csrf_field() }}

		        <h5>Documento</h5>

		        <!-- form-group -->
		        <div class="form-group">

		          <label class="control-label col-lg-1">Tipo Doc:</label>
		          <div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="tipo_doc" value="{{$documento->tipo}}" readonly>
		          </div>

		          <label class="control-label col-lg-1">Numero:</label>
		          <div class="col-lg-1">
		            <input class="form-control input-sm" type="text" name="numero" value="{{$documento->numero}}" readonly>
		          </div>

		          <label class="control-label col-lg-1">Version:</label>
		          <div class="col-lg-1">
		            <input class="form-control input-sm" name="version" type="number" min="0" value="{{$documento->version}}" readonly>
		          </div>

		        </div>
		        <!-- /form-group -->

				<div class="form-group">
					<label class="control-label col-lg-1">Bodega:</label>
 		           <div class="col-lg-3">
 		             <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodega" v-model="bodega" required>
						<option v-for="bodega in bodegas" :value="bodega.id">@{{bodega.descripcion}}</option>
 		             </select>
 		           </div>

				   <div class="col-lg-1">
				   		<button class="btn btn-sm btn-default" type="button" @click="consult">Consultar</button>
				   </div>

				</div>

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
              <th class="text-center">Cantidad</th>
              <th class="text-center">Existencia</th>
              <th class="text-center">Disponible</th>
            </tr>

          </thead>

          <tbody>

              <tr v-for="(item,key) in items">
                <td class="text-center">@{{key+1}}</td>
                <td class="text-center">@{{item.codigo}}</td>
                <td class="text-center">@{{item.descripcion}}</td>
                <td class="text-right">@{{item.cantidad}}</td>
                <td class="text-right">@{{item.existencia}}</td>
                <td :class="item.existencia>=item.cantidad ? 'success':'danger'" class="text-center">@{{item.existencia>=item.cantidad ? 'Disponible' : 'No disponible'}}</td>
              </tr>

          </tbody>

        </table>

      </div>

	  <div class="pull-right">
	  	<form id="create" method="post" action="{{route('guardarEgrOrdenEgreso')}}">
			{{ csrf_field() }}
	  		<button form="create" :disabled="!validate" class="btn btn-sm btn-default" type="submit">Generar Orden de Egreso</button>
			<input form="create" class="form-control input-sm" name="bodega" type="hidden" :value="bodega" readonly>
			<input form="create" class="form-control input-sm" name="tipo" type="hidden" value="{{$documento->tipo_id}}" readonly>
			<input form="create" class="form-control input-sm" name="id" type="hidden" value="{{$documento->id}}" readonly>
		</form>
	  </div>

    </div>
    <!-- /box-footer -->

  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var tipoDoc = {!!$documento->tipo_id!!};
	var docId = {!!$documento->id!!};
	var items = {!!$documento->detalles!!};
	var bodegas = {!!$bodegas!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/bodega/egreso/createEgrOrdenEgreso.js')}}"></script>
@endsection
