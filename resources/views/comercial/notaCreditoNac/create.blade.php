@extends('layouts.master2')

@section('content')

    <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Nota de Credito</h4>
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
    		<!-- form Cargar Factura -->
    		<form id="import"  action="{{route('crearNotaCreditoNac')}}" method="get">
    		</form>
    		<!-- /form -->
    		<!-- form -->
    		<form class="form-horizontal"  id="create" method="post" action="{{route('guardarNotaCreditoNac')}}">

				{{ csrf_field() }}

                <h5>Documento</h5>

                <!-- form-group -->
                <div class="form-group form-group-sm">


                    <label class="control-label col-lg-1">Factura:</label>
                    <div class="col-lg-1">
                        <input form="import" placeholder="Numero..." class="form-control input-sm" name="factura" type="number" min="0" value="{{$factura ? $factura->numero : '' }}" required>
                        <input class="form-control input-sm" name="factura"  type="hidden" min="0" value="{{$factura ? $factura->numero : '' }}" required>
                    </div>

                    <div class="col-lg-1">
                        <button form="import" class="btn btn-sm btn-default" type="submit">Cargar</button>
                    </div>

					<label class="control-label col-lg-2">Nota Credito N°:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="numero" required>
					</div>

					<div class="col-lg-1 col-lg-offset-4">
						<button type="button" class="btn btn-default btn-sm" @click="processAnulation" >Anular Factura</button>
					</div>

                </div>
                <!-- /form-group -->

                <h5>Datos</h5>

                <!-- form-group -->
                <div class="form-group">

                  <label class="control-label col-lg-1">Fecha:</label>
                  <div class="col-lg-2">
                    <input class="form-control input-sm" name="fecha" type="date" required>
                  </div>

                </div>
                <!-- /form-group -->

		        <!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-4">
						<input class="form-control input-sm" type="text" name="cliente" value="{{ $factura ? $factura->cliente : '' }}" readonly>
					</div>

					<label class="control-label col-lg-2">Condicion Pago:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="formaPago" value="{{ $factura ? $factura->cond_pago : ''}}" readonly>
					</div>

		        </div>
		        <!-- /form-group -->
				<hr>
				<!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Nota:</label>
					<div class="col-lg-8">
						<input class="form-control input-sm" type="text" name="nota" v-model="nota" placeholder="Nota o Observacion de Nota de Credito">
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

          <label class="control-label col-lg-1">precio:</label>
          <div class="col-lg-2">
		  	<moneda-input v-model="precio"></moneda-input>
          </div>

          <div class="col-lg-2">
            <button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
            <button class="btn btn-sm btn-default" type="button" name="button" @click="removeItem">Borrar</button>
          </div>

		  <!-- Items -->
		  <select style="display: none;" name="items[]" multiple>
			  <option v-for="item in items" selected>
				  @{{item}}
			  </option>
		  </select>
		  <!-- /items -->

		</div>
        <!-- /form-group -->

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
            <td class="text-right">@{{numberFormatDecimal(item.precio)}}</td>
			<td class="text-right">@{{numberFormat(item.sub_total)}}</td>
          </tr>

        </tbody>

      </table>

      <div class="row">

		  <div class=" col-sm-3 col-md-offset-9">
  			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

  					<tr>
  						<th class="bg-gray text-right">Sub-Total:</th>
  						<td class="input-td">
							<moneda-input-readonly v-model="sub_total"></moneda-input-readonly>
						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">Neto:</th>
  						<td class="input-td">
							<moneda-input-readonly v-model="neto"></moneda-input-readonly>
  						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">IABA:</th>
  						<td class="input-td">
							<moneda-input-readonly v-model="iaba"></moneda-input-readonly>
  						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">I.V.A:</th>
  						<td class="input-td">
							<moneda-input-readonly v-model="iva"></moneda-input-readonly>
  						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">TOTAL:</th>
  						<th class="bg-gray input-td">
							<moneda-input-readonly v-model="total"></moneda-input-readonly>
  						</th>
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
	var factura = {!!$factura ? $factura->numero : "[]"!!};
	var impIaba = {!!$factura ? $factura->iaba : "[]"!!};
	var productos = {!! $factura ? $factura->detalles->toJson() : "[]" !!};
	var sub_total = 0; //{!! $factura ? $factura->sub_total : "[]" !!};
	var descuentoTotal = 0; //{!! $factura ? $factura->descuento : "[]" !!};
	var neto = 0; //{!! $factura ? $factura->neto : "[]" !!};
	var iaba = 0; //{!! $factura ? $factura->iaba : "[]" !!};
	var iva = 0; //{!! $factura ? $factura->iva : "[]" !!};
	var total = 0; //{!! $factura ? $factura->total : "[]" !!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('vue/components/formatos-inputs.js')}}"></script>
<script src="{{asset('js/comercial/createNotaCredito.js')}}"></script>
@endsection
