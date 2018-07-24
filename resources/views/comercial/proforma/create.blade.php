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
			<!-- form importar proforma -->
			<form id="import"  action="{{route('crearDeProforma')}}" method="post">
				{{ csrf_field() }}
			</form>
			<!-- /form -->
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
				<input class="form-control input-sm" type="text" name="numero">
			</div>

			<label class="control-label col-lg-1">Version:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" name="version" type="number" min="0" value="1" readonly>
			</div>


			<label class="control-label col-lg-1 col-lg-offset-2">Proforma:</label>
			<div class="col-lg-1">
			  <input form="import" placeholder="Numero..." class="form-control input-sm" name="proforma" type="number" min="0" required>
			</div>
			<div class="col-lg-1">
				<button form="import" class="btn btn-sm btn-default" type="submit">Importar</button>
			</div>

        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emision:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" name="emision" type="date" value="{{$fecha}}" required>
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="clausula" v-model="clausulaID" @change="updateClausula" required>
              <option value=""></option>
              <option v-for="clausula in clausulas"  :value="clausula.nombre">@{{clausula.nombre}}</option>
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
            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente" v-model="clienteId" @change="loadDatos" required>
							<option value=""></option>
							<option v-for="cliente in clientes" v-bind:value="cliente.id">@{{cliente.descripcion}}</option>
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Direccion:</label>
			<div class="col-lg-4">
				<input class="form-control input-sm" type="text" name="direccion" v-model="direccion" readonly>
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
            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="puertoE" required>
              <option value=""></option>
							@foreach ($puertoEmbarque as $puerto)

								<option {{Input::old('puertoE') == $puerto->nombre ? 'selected':''}} value="{{$puerto->nombre}}">{{$puerto->nombre}}</option>

							@endforeach
            </select>
          </div>

					<label class="control-label col-lg-2">Medio Transporte:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="transporte" required>
							<option value=""></option>
							@foreach ($transportes as $transporte)

								<option {{Input::old('transporte') == $transporte->descripcion ? 'selected':''}} value="{{$transporte->descripcion}}">{{$transporte->descripcion}}</option>

							@endforeach
						</select>
					</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Dir.Desp.:</label>
          <div class="col-lg-5">
			<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default btn-sm" name="despacho" required>
				<option v-if="sucursales" v-for="sucursal in sucursales" v-bind:value="sucursal.direccion">@{{sucursal.descripcion + " - " + sucursal.direccion }}</option>
			</select>
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
            <input class="form-control input-sm" type="text" name="nota" value="{{Input::old('nota')}}">
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
            <input class="form-control input-sm" type="number" min="0" pattern="0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" v-model.number="cantidad">
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
            <button id="addItem" class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
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

      <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

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

      <div class="row">
        <div class=" col-sm-3">
          <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

              <tr>
                <th class="bg-gray text-right">Peso Neto:</th>
                <td class="text-right">@{{totalPesoNeto.toLocaleString()}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Peso Bruto:</th>
                <td class="text-right">@{{totalPesoBruto.toLocaleString()}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Volumen:</th>
                <td class="text-right">@{{totalVolumen.toLocaleString()}}</td>
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
						<input id="freight" class="form-control text-right" type="number" name="freight" min="0" step="0.01" v-model.number="freight" :disabled="!freightValidator" @change="freightChange">
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">INSURANCE US$</th>
					<td class="input-td">
						<input class="form-control text-right" type="number" lang="es" min="0" step="0.01" name="insurance" v-model.number="insurance" :disabled="!insuranceValidator" @change="insuranceChange">
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

      </div>

      <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
		var productos = Object.values({!!$productos!!});
		var clientes = {!!$clientes!!};
		var clausulas = {!!$clausulas!!};
		var items = [];
	</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/proforma.js')}}"></script>
@endsection
