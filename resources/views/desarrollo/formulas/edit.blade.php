@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Modificar Formula</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			@if ($errors->any())

				@foreach ($errors->all() as $error)

					@component('components.errors.validation')

            @slot('errors')

              {{$error}}

						@endslot

					@endcomponent

				@endforeach

			@endif

			<!-- form -->
			<form class="form-horizontal"  id="edit" method="post" action="">

				{{ csrf_field() }}
				{{ method_field('PUT') }}

        <h5>Producto</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">producto:</label>
          <div class="col-lg-5">
			  <input class="form-control input-sm" type="text" name="producto" value="{{$formula->producto->descripcion}}" readonly>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Formato:</label>
			<div class="col-lg-2">
				<input class="form-control input-sm" type="text" name="numero" value="{{$formula->producto->formato->descripcion}}" readonly>
			</div>

			<label class="control-label col-lg-1">Batch:</label>
			<div class="col-lg-2">
				<div class="input-group">
					<input class="form-control input-sm" name="bacth" type="number" min="0" value="{{$formula->cant_batch}}" required>
					<span class="input-group-addon">Kg</span>
				</div>
			</div>

        </div>
        <!-- /form-group -->
		<hr>
        <h5>Insumos</h5>

		<!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Nivel:</label>
			<div class="col-lg-2">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="nivel" required>
					<option value=""></option>
					<option v-for="nivel in niveles" :value="nivel.id">@{{nivel.descripcion}}</option>
				</select>
			</div>

			<label class="control-label col-lg-1">Insumos:</label>
			<div class="col-lg-3">
			  <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="insumo" v-model="itemId" @change="loadInsumo" required>
			    	<option value=""></option>
					<option v-for="insumo in insumos" :value="insumo.id">@{{insumo.descripcion}}</option>
			  </select>
			</div>

			<label class="control-label col-lg-1">CantXuni:</label>
			<div class="col-lg-2">
				<div class="input-group">
					<input class="form-control" type="number" min="0" step="any" class="form-control" name="cantidad" v-model="cantidad" placeholder="cantidad x Unidad...">
					<span class="input-group-addon">Un / Kg</span>
				</div>
			</div>

			<div class="col-lg-2">
				<button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
				<button class="btn btn-sm btn-default" type="button" name="button" @click="removeItem">Borrar</button>
			</div>
        </div>
        <!-- /form-group -->

				<!-- Items -->
				<select style="display: none;"  name="items[]" multiple>
					<option v-for="item in items" selected>
						@{{item}}
					</option>
				</select>
				<!-- /items -->

      </form>
      <!-- /form -->

    </div>
    <!-- /box-body -->

    <!-- box-footer -->
    <div class="box-footer">

      <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

        <thead>

          <tr>
            <th class="text-center">#</th>
            <th class="text-center">CODIGO</th>
            <th class="text-center">DESCRIPCION</th>
            <th class="text-center">C. Envase</th>
            <th class="text-center">C. Caja</th>
            <th class="text-center">C. Batch</th>
            <th class="text-center">Nivel</th>
          </tr>

        </thead>

        <tbody>
					<tr v-if="items <= 0">
						<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
					</tr>

          <tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.producto_id)">
            <td class="text-center">@{{key+1}}</td>
            <td class="text-center">@{{item.codigo}}</td>
            <td>@{{item.descripcion}}</td>
            <td class="text-right">@{{item.cantidad.toLocaleString()}}</td>
            <td class="text-right">@{{numberFormat(item.precio)}}</td>
            <td class="text-right">@{{numberFormat(item.descuento)}}</td>
						<td class="text-right">@{{numberFormat(item.sub_total)}}</td>
          </tr>

        </tbody>

      </table>
		{{--
      <div class="row">
        <div class=" col-sm-3">
          <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

              <tr>
                <th class="bg-gray text-right">Peso Neto:</th>
                <td class="text-right">@{{totalPesoNeto}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Peso Bruto:</th>
                <td class="text-right">@{{totalPesoBruto}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Volumen:</th>
                <td class="text-right">@{{totalVolumen}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Cant. Cajas:</th>
                <td class="text-right">@{{totalCajas}}</td>
              </tr>


          </table>
        </div>
        <div class=" col-sm-3 col-md-offset-6">
			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

			<tr>
				<th class="bg-gray text-right">TOTAL F.O.B. US$</th>
				<th class="text-right">@{{numberFormat(fob)}}</th>
			</tr>
			<tr>
				<th class="bg-gray text-right">FREIGHT US$</th>
				<td class="input-td">
					<input id="freight" class="form-control text-right" type="number" name="freight" min="0" step="0.01" v-model.number="freight" @change="freightChange">
				</td>
			</tr>
			<tr>
				<th class="bg-gray text-right">INSURANCE US$</th>
				<td class="input-td">
					<input class="form-control text-right" type="number" lang="es" min="0" step="0.01" name="insurance" v-model.number="insurance" @change="insuranceChange">
				</td>
			</tr>
			<tr>
				<th colspan="2" class=""></th>
			</tr>
			<tr>
				<th class="bg-gray text-right">TOTAL US$</th>
				<th class="bg-gray text-right">@{{numberFormat(total)}}</th>
			</tr>

			</table>
        </div>

	</div> --}}

      <button form="edit" class="btn btn-default pull-right" type="submit">Modificar</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var insumos = {!!$insumos!!};
	var niveles = {!!$niveles!!};
	var items = {!!$formula->detalle!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/desarrollo/formulaEdit.js')}}"></script>
@endsection
