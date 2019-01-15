@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Editar Orden de Compra</h4>
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
			<form class="form-horizontal"  id="edit" method="post" action="{{route('actualizarOrdenCompra',['ordenCompra' => $ordenCompra->id])}}">

				{{ csrf_field() }}
				{{ method_field('PUT') }}

        <h5>Documento</h5>

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Numero:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" type="text" name="numero" value="{{$ordenCompra->numero}}" readonly>
			</div>

        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Proveedor:</label>
            <div class="col-lg-4">
				<input class="form-control input-sm" name="prov_id" type="text" value="{{$ordenCompra->proveedor->descripcion}}" readonly>
            </div>

			<label class="control-label col-lg-1">Emisión:</label>
			<div class="col-lg-2">
				<input class="form-control input-sm" name="fecha_emision" type="date" value="{{$ordenCompra->fecha_emision}}" readonly>
			</div>

			<label class="control-label col-lg-1">Area:</label>
            <div class="col-lg-2">
				<input class="form-control input-sm" name="area_id" type="text" value="{{$ordenCompra->area->descripcion}}" readonly>
            </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Cond. Pago:</label>
			<div class="col-lg-4">
				<input class="form-control input-sm" type="text" name="forma_pago" v-model="formaPagoDescrip" readonly>
			</div>

			<label class="control-label col-lg-1">Moneda:</label>
            <div class="col-lg-2">
              <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="moneda" required>
                <option value=""></option>
				@foreach ($monedas as $moneda)
					<option {{$ordenCompra->moneda == $moneda->descripcion ? 'selected':''}} value="{{$moneda->id}}">{{$moneda->descripcion}}</option>
				@endforeach
              </select>
            </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Contacto:</label>
			<div class="col-lg-4">
				<input class="form-control input-sm" type="text" name="contacto" v-model="contacto" readonly>
			</div>

			<div class="col-lg-4">
				<div v-for="tipo in tipos" class="radio-inline">
					<label>
						<input type="radio" name="tipo" :id="tipo.id" :value="tipo.id" v-model="tipoId" onclick="return false;">
							@{{tipo.descripcion}}
					</label>
				</div>
			</div>

        </div>
        <!-- /form-group -->

		<!-- form-group -->
        <div class="form-group">
          <label class="control-label col-lg-1">Nota:</label>
          <div class="col-lg-10">
            <input class="form-control input-sm" type="text" name="nota" value="{{$ordenCompra->nota}}" readonly>
          </div>
	  	</div>
        <!-- /form-group -->

        <h5>Detalle</h5>
        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Tipo:</label>
          <div class="col-lg-3">
            <select id="prodSelect" class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" :disabled="itemSelected">
				<option value="">MP / Insumo</option>
            </select>
          </div>

		  <label class="control-label col-lg-1">Producto:</label>
          <div class="col-lg-3">
            <select id="prodSelect" class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model.lazy="prodId" @change="loadProducto" :disabled="itemSelected">
				<option value=""></option>
				<option v-if="productos" v-for="producto in productos" v-bind:value="producto.id">@{{producto.descripcion}}</option>
            </select>
          </div>

		  <label class="control-label col-lg-1">Ult.Precio:</label>
		  <div class="col-lg-1">
        	<input class="form-control input-sm" type="text" v-model.lazy="ultPrecio" readonly>
          </div>

        </div>
        <!-- /form-group -->
        <!-- form-group -->
        <div class="form-group">

		  <label class="control-label col-lg-1">Descripcion:</label>
		  <div class="col-lg-3">
        	<input class="form-control input-sm" type="text" name="descripProd" v-model.lazy="descripProd">
          </div>

		  <label class="control-label col-lg-1">U.Med:</label>
		  <div class="col-lg-1">
        	<input class="form-control input-sm" type="text" name="unidad" v-model.lazy="unidad">
          </div>

          <label class="control-label col-lg-1">Cant:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" pattern="0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" v-model.lazy="cantidad">
          </div>

          <label class="control-label col-lg-1">precio:</label>
          <div class="col-lg-1">
            <input id="precio" class="form-control input-sm" type="number" min="0" v-model.number="precio">
          </div>

          <div class="col-lg-2">
            <button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
            <button class="btn btn-sm btn-default" type="button" name="button" @click="removeItem">Borrar</button>
          </div>

        </div>
        <!-- /form-group -->

				<!-- Items -->
				<select style="display: none;"  name="items[]" multiple required>
					<option v-for="item in items" selected>
						@{{item}}
					</option>
				</select>
				<!-- /items -->
				<input type="hidden" name="aut_contab" value="1">
				{{-- <input type="hidden" name="freight" :value="freight"> --}}
				{{-- <input type="hidden" lang="es" name="insurance" :value="insurance"> --}}
				{{-- <input type="hidden" name="fob" :value="fob"> --}}
				{{-- <input type="hidden" name="total" :value="total"> --}}

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
			<th class="text-center">U.MED</th>
            <th class="text-center">CANT</th>
            <th class="text-center">PRECIO</th>
            <th class="text-center">TOTAL</th>
          </tr>

        </thead>

        <tbody>
					<tr v-if="items <= 0">
						<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
					</tr>

          <tr v-if="items" v-for="(item,key) in items" @click="loadItem(key)">
            <td class="text-center">@{{key+1}}</td>
            <td class="text-center">@{{item.codigo}}</td>
            <td>@{{item.descripcion}}</td>
			<td class="text-right">@{{item.unidad}}</td>
            <td class="text-right">@{{item.cantidad}}</td>
            <td class="text-right">@{{numberFormat(item.precio)}}</td>
			<td class="text-right">@{{numberFormat(item.sub_total)}}</td>
          </tr>

        </tbody>

      </table>

      <div class="row">

        <div class=" col-sm-4 col-md-offset-8">
			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

				<tr>
					<th class="bg-gray text-right">SUB-TOTAL :</th>
					<td class="input-td">
					<input class="form-control text-right" type="number" name="sub_total" :value="subTotal.toFixed(2)" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">DESCUENTO :</th>
					<td class="input-td">
						<input class="form-control text-right" type="number" name="descuento" :value="descuento.toFixed(2)" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">@{{ivaLabelText}}</th>
					<td class="input-td">
						<input class="form-control text-right" type="number" name="impuesto" :value="impuesto.toFixed(2)" readonly>
					</td>
				</tr>
				<tr>
					<th colspan="2" class=""></th>
				</tr>

				<tr>
					<th class="bg-gray text-right">@{{totalLabelText}}</th>
					<td class="input-td">
						<input class="form-control text-right" type="number" name="freight" min="0" step="0.01" :value="total.toFixed(2)" readonly>
					</td>
				</tr>

			</table>
        </div>

      </div>

      <button form="edit" class="btn btn-default pull-right" type="submit">Modificar</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var productos = Object.values({!!json_encode($productos)!!});
	var tipos = Object.values({!!$tipos!!});
	var tipoId = {!!$ordenCompra->tipo_id!!}
	var proveedores = {!!$proveedores!!};
	var proveedorId = {!!$ordenCompra->prov_id!!};
	var items = {!!$ordenCompra->detalles!!};
	var iva = {!!$iva!!};
	var porcDesc = {!!$ordenCompra->porcDesc!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/adquisicion/ordenCompraEdit.js')}}"></script>
@endsection
