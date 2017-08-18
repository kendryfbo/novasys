@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Proforma</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarProforma')}}">

				{{ csrf_field() }}

        <h5>Documento</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">C. Venta:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
							@foreach ($centrosVenta as $centro)

								<option {{Input::old('centroVenta') ? 'selected':''}} value="{{$centro->id}}">{{$centro->descripcion}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-1">Numero:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="text" name="numero" value="NUEVA" readonly>
          </div>

          <label class="control-label col-lg-1">Version:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" name="version" type="number" min="0" value="1" readonly>
          </div>

        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emision:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" name="emision" type="date" value="{{Input::old('emision')}}">
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="clausula" required>
              <option value=""></option>
							@foreach ($clausulas as $clausula)

								<option {{Input::old('clausula') ? 'selected':''}} value="{{$clausula->nombre}}">{{$clausula->nombre}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-1">Semana:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" name="semana" type="number" min="1" max="52" value="{{Input::old('semana')}}">
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="cliente" v-model="clienteId" @change="loadFormaPago" required>
							<option value=""></option>
							<option v-for="cliente in clientes" v-bind:value="cliente.id">@{{cliente.descripcion}}</option>
            </select>
          </div>

					<label class="control-label col-lg-2">Condicion Pago:</label>
          <div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="formaPago" v-model="formaPagoDescrip" readonly>
          </div>


        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Puerto E. :</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="puertoE" required>
              <option value=""></option>
							@foreach ($aduanas as $aduana)

								<option {{Input::old('puertoE') ? 'selected':''}} value="{{$aduana->descripcion}}">{{$aduana->descripcion}}</option>

							@endforeach
            </select>
          </div>

					<label class="control-label col-lg-2">Medio Transporte:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="transporte" required>
							<option value=""></option>
							@foreach ($transportes as $transporte)

								<option {{Input::old('transporte') ? 'selected':''}} value="{{$transporte->descripcion}}">{{$transporte->descripcion}}</option>

							@endforeach
						</select>
					</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Direccion:</label>
          <div class="col-lg-5">
            <input class="form-control input-sm" type="text" name="direccion" value="{{Input::old('direccion')}}" required>
          </div>

          <label class="control-label col-lg-1">Puerto D. :</label>
          <div class="col-lg-4">
            <input class="form-control input-sm" type="text" name="puertoD" value="{{Input::old('puertoD')}}">
          </div>

        </div>
        <!-- /form-group -->

				<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Nota:</label>
          <div class="col-lg-10">
            <input class="form-control input-sm" type="text" name="nota" value="{{Input::old('nota')}}" required>
          </div>

        </div>
        <!-- /form-group -->

        <h5>Detalle</h5>
        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Producto:</label>
          <div class="col-lg-2">
            <select id="prodSelect" class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" v-model="prodId" @change="loadProducto" :disabled="itemSelected">
							<option value=""></option>
							<option v-if="productos" v-for="producto in productos" v-bind:value="producto.id">@{{producto.descripcion}}</option>
            </select>
          </div>

          <label class="control-label col-lg-1">Cant:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" v-model.number="cantidad">
          </div>

          <label class="control-label col-lg-1">% desc:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" max="100" v-model.number="descuento" value="0">
          </div>

          <label class="control-label col-lg-1">precio:</label>
          <div class="col-lg-2">
            <input id="precio" class="form-control input-sm" type="number" min="0" v-model.number="precio">
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

				<input type="hidden" name="freight" :value="freight">
				<input type="hidden" lang="es" name="insurance" :value="insurance">
				<input type="hidden" name="fob" :value="fob">
				<input type="hidden" name="total" :value="total">

      </form>
      <!-- /form -->

    </div>
    <!-- /box-body -->

    <!-- box-footer -->
    <div class="box-footer">

      <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

        <thead>

          <tr>
            <th class="text-center">#</th>
            <th class="text-center">CODIGO</th>
            <th class="text-center">DESCRIPCION</th>
            <th class="text-center">CANT</th>
            <th class="text-center">PRECIO</th>
            <th class="text-center">DESC</th>
            <th class="text-center">TOTAL</th>
          </tr>

        </thead>

        <tbody>
					<tr v-if="items <= 0">
						<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
					</tr>

          <tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.id)">
            <td class="text-center">@{{key+1}}</td>
            <td class="text-center">@{{item.codigo}}</td>
            <td>@{{item.descripcion}}</td>
            <td class="text-right">@{{item.cantidad.toLocaleString()}}</td>
            <td class="text-right">@{{item.precio.toLocaleString()}}</td>
            <td class="text-right">@{{item.descuento.toLocaleString()}}</td>
						<td class="text-right">@{{item.total.toLocaleString()}}</td>
          </tr>

        </tbody>

      </table>

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
                <th class="bg-gray text-right">FREIGHT:</th>
                <td class="input-td">
                	<input id="freight" class="form-control text-right" type="number" name="freight" min="0" step="0.01" v-model.number="freight" @change="freightChange">
                </td>
              </tr>
              <tr>
                <th class="bg-gray text-right">INSURANCE:</th>
								<td class="input-td">
                	<input class="form-control text-right" type="number" lang="es" min="0" step="0.01" name="insurance" v-model.number="insurance" @change="insuranceChange">
                </td>
              </tr>
							<tr>
								<th colspan="2" class=""></th>
							</tr>
							<tr>
								<th class="bg-gray text-right">TOTAL F.O.B.:</th>
								<th class="text-right">@{{fob}}</th>
							</tr>

              <tr>
                <th class="bg-gray text-right">TOTAL:</th>
                <th class="bg-gray text-right">@{{total}}</th>
              </tr>

          </table>
        </div>

      </div>

      <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
		var productos = {!!$productos!!};
		var clientes = {!!$clientes!!};
		var items = []; // {!!(Input::old('items') ? json_encode(Input::old('items')):"[]")!!}
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/proforma.js')}}"></script>
@endsection
