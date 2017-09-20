@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision Factura Internacional S.I.I</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('notasVentas.store')}}">

				{{ csrf_field() }}

        <!-- form-group -->
        <div class="form-group form-group-sm">

          <label class="control-label col-lg-1">Factura N°:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="numero"  min="0" readonly>
          </div>

          <label class="control-label col-lg-1">Proforma:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="text" name="proforma">
          </div>

          <div class="col-lg-1">
            <button class="btn btn-default btn-sm" type="button" name="button">Importar</button>
          </div>

        </div>
        <!-- /form-group -->

		<div class="form-group form-group-sm">

			<label class="control-label col-lg-1">Emision:</label>
            <div class="col-lg-2">
              <input class="form-control input-sm" type="date" name="emision">
            </div>

            <label class="control-label col-lg-1">Vencimiento:</label>
            <div class="col-lg-2">
              <input class="form-control input-sm" type="date" name="vecimiento">
            </div>
			
		</div>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">C. Venta:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
              @foreach ($centrosVenta as $centro)

                <option value="{{$centro->id}}">{{$centro->descripcion}}</option>

              @endforeach
            </select>
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
							@foreach ($clausulas as $clausula)

								<option value="{{$clausula->id}}">{{$clausula->nombre}}</option>

							@endforeach
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
							@foreach ($clientes as $cliente)

								<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-2">Medio Transporte:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
							@foreach ($transportes as $transporte)

								<option value="{{$transporte->id}}">{{$transporte->descripcion}}</option>

							@endforeach
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Puerto E. :</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
							@foreach ($aduanas as $aduana)

								<option value="{{$aduana->descripcion}}">{{$aduana->descripcion}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-2">Condicion Pago:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
            </select>
          </div>


        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Direccion:</label>
          <div class="col-lg-5">
            <input class="form-control input-sm"type="text" name="direccion">
          </div>

          <label class="control-label col-lg-1">Puerto D. :</label>
          <div class="col-lg-4">
            <input class="form-control input-sm" type="text" name="direccion" value="">
          </div>

        </div>
        <!-- /form-group -->

        <h5>Detalle</h5>
        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Producto:</label>
          <div class="col-lg-2">
            <select id="prodSelect" class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" v-model="prodId" @change="loadProducto" :disabled="itemSelected" required>
							<option value=""></option>
							<option v-if="productos" v-for="producto in productos" v-bind:value="producto.id">@{{producto.descripcion}}</option>
            </select>
          </div>

          <label class="control-label col-lg-1">Cant:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" name="cantidad" v-model.number="cantidad">
          </div>

          <label class="control-label col-lg-1">% desc:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" max="100" name="descuento" v-model.number="descuento" value="0">
          </div>

          <label class="control-label col-lg-1">precio:</label>
          <div class="col-lg-2">
            <input id="precio" class="form-control input-sm" type="number" min="0" name="precio" v-model.number="precio">
          </div>

          <div class="col-lg-2">
            <button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
            <button class="btn btn-sm btn-default" type="button" name="button" @click="removeItem">Borrar</button>
          </div>

        </div>
        <!-- /form-group -->

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

					<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>

          <tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.id)">
            <td class="text-center">@{{key+1}}</th>
            <td class="text-center">@{{item.codigo}}</th>
            <td>@{{item.descripcion}}</th>
            <td class="text-right">@{{item.cantidad.toLocaleString()}}</th>
            <td class="text-right">@{{item.precio.toLocaleString()}}</th>
            <td class="text-right">@{{item.descuento.toLocaleString()}}</th>
						<td class="text-right">@{{item.total.toLocaleString()}}</th>
          </tr>

        </tbody>

      </table>

      <div class="row">
        <div class=" col-sm-3">
          <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

              <tr>
                <th class="bg-gray text-right">Peso Neto:</th>
                <td class="text-right">@{{totalPesoNeto}}</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Peso Bruto:</th>
                <td class="text-right">@{{totalPesoBruto}}</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Volumen:</th>
                <td class="text-right">@{{totalVolumen}}</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Cant. Cajas:</th>
                <td class="text-right">@{{totalCajas}}</th>
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

      <button class="btn btn-default pull-right" type="button" name="button">Crear</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
@endsection
