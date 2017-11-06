@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Nota de Venta</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- errores -->
			@if ($errors->any())

				<ol>

					@foreach ($errors->all() as $error)

						@component('components.errors.validation')
							@slot('errors')
								{{$error}}
							@endslot
						@endcomponent

					@endforeach

				</ol>

			@endif

			<!-- form -->
			<form  id="create" method="post" action="{{route('notasVentas.store')}}">

				{{ csrf_field() }}

				<!-- form-horizontal -->
				<div class="form-horizontal">
					<h5>Documento</h5>
					<div class="form-group form-group-sm">
						<label class="control-label col-sm-2" >Centro de Venta:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="centroVenta" required>
								<option value="">Seleccionar Centro de Venta...</option>
								@foreach ($centrosVentas as $centroVenta)
									<option {{ Input::old('centroVenta') == $centroVenta->id ? 'selected' : '' }} value="{{$centroVenta->id}}">{{$centroVenta->descripcion}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group form-group-sm">
						<label class="control-label col-sm-2" >Numero:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="numero" placeholder="Numero Nota Venta..." value="Nueva" readonly>
						</div>

						<label class="control-label col-sm-1" >Version:</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="version" value="1" readonly>
						</div>
					</div>

					<h5>Datos</h5>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Fecha Emision:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control" name="fechaEmision" value="{{ Input::old('fechaEmision') ? Input::old('fechaEmision') : '' }}" required>
						</div>

						<label class="control-label col-lg-2">Fecha despacho:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control " name="fechaDespacho" value="{{ Input::old('fechaDespacho') ? Input::old('fechaDespacho') : '' }}" required>
						</div>

						<label class="control-label col-lg-1" >O. Compra:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="orden_compra" placeholder="Numero..." value="{{ Input::old('orden_compra') ? Input::old('orden_compra') : '' }}">
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Cliente:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="500" data-live-search="true" data-style="btn-default btn-sm" name="cliente" v-model="cliente" @change="getData" required>
								<option value="">Seleccionar Cliente...</option>
								@foreach ($clientes as $cliente)
									<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
								@endforeach
							</select>
						</div>

						<label class="control-label col-lg-2">Cond. Pago:</label>
						<div class="col-lg-2">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="formaPago" required>
								<option v-if="formaPagoDescrip" selected v-bind:value="formaPagoDescrip">@{{formaPagoDescrip}}</option>
							</select>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Despacho:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="600px" data-live-search="true" data-style="btn-default btn-sm" name="despacho" v-model="despacho" required>
								<option value="">Direccion de despacho...</option>
								<option v-if="sucursales" v-for="sucursal in sucursales" :value="sucursal.direccion">@{{sucursal.descripcion +' - '+sucursal.direccion}}</option>
							</select>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Vendedor:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="vendedor" required>
								<option value="">Seleccionar Vendedor...</option>
								@foreach ($vendedores as $vendedor)
									<option {{ Input::old('vendedor') == $vendedor->id ? 'selected' : '' }} value="{{$vendedor->id}}">{{$vendedor->nombre}}</option>
								@endforeach
							</select>
						</div>

					</div>

				</div>
				<!-- /form-horizontal -->

				<select style="display: none;"  name="items[]" multiple>
					<option v-for="item in items" selected>
						@{{item}}
					</option>
				</select>
				<input type="hidden" name="subtotal" v-bind:value="subTotal">
				<input type="hidden" name="descuento" v-bind:value="descuento">
				<input type="hidden" name="neto" v-bind:value="neto">
				<input type="hidden" name="iva" v-bind:value="iva">
				<input type="hidden" name="iaba" v-bind:value="totalIaba">
				<input type="hidden" name="total" v-bind:value="total">
				<input type="hidden" name="peso_neto" v-bind:value="totalPesoNeto">
				<input type="hidden" name="peso_bruto" v-bind:value="totalPesoBruto">
				<input type="hidden" name="volumen" v-bind:value="totalVolumen">
			</form>
			<!-- /form -->
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body">

			<h5>Detalles</h5>
			<!-- form-horizontal -->
			<div class="form-horizontal">

				<div class="form-group form-group-sm">
					<label class="col-lg-2  text-left control-label">Lista Precios:</label>
					<div class="col-lg-4">
						<select class="selectpicker form-control" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="lista" disabled>
							<option v-if="listaDescrip" selected v-bind:value="listaId">@{{listaDescrip}}</option>
						</select>
					</div>
				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-default btn-sm" name="producto" v-model="producto" @change="loadProducto">
							<option value="">Producto...</option>
							<option v-if="listaDetalle" v-for="detalle in listaDetalle" v-bind:value="detalle.id">@{{detalle.producto.descripcion}}</option>
						</select>
					</div>

					<label class="control-label col-lg-1">Cant:</label>
					<div class="col-lg-1">
						<input class="form-control text-right" type="number" min="0" step="1" pattern="0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="cantidad" v-model.number="cantidad">
					</div>

					<label class="control-label col-lg-1">%Dscto:</label>
					<div class="col-lg-1">
						<input class="form-control text-right" type="number" name="descuento" v-model.number="descuento" disabled>
					</div>

					<label class="control-label col-lg-1">Precio:</label>
					<div class="col-lg-1">
						<input class="form-control" type="hidden" name="precio" v-model.number="precio" disabled>
						<input class="form-control text-right" type="text" name="strPrecio" :value="precio.toLocaleString()" disabled>
					</div>

					<div class="col-lg-2">
						<button class="btn btn-default btn-sm" type="button" @click="insertItem">Agregar</button>
						<button class="btn btn-default btn-sm" type="button" @click="removeItem">Borrar</button>
					</div>
				</div>

				<div class="form-group">
				</div>

			</div>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body" style="overflow-y: scroll;max-height:500px;border:1px solid black;">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">codigo</th>
						<th class="text-center">descripcion</th>
						<th class="text-center">Cantidad</th>
						<th class="text-center">Precio</th>
						<th class="text-center">Dscto</th>
						<th class="text-center">total</th>
					</tr>
				</thead>
				<tbody>
					<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
					<tr v-for="(item,key) in items" v-bind:class="[key === select ? 'active' : '']"  @click="loadItem(key)">
						<th class="text-center">@{{key+1}}</th>
						<td class="text-center">@{{item.codigo}}</td>
						<td>@{{item.descripcion}}</td>
						<td class="text-right">@{{item.cantidad}}</td>
						<td class="text-right">@{{item.precio.toLocaleString()}}</td>
						<td class="text-right">@{{item.descuento}}</td>
						<td class="text-right">@{{item.total.toLocaleString()}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">

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
								<td class="text-right">@{{cajas}}</td>
							</tr>


					</table>
				</div>
				<div class=" col-sm-3 col-md-offset-6">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Sub-Total:</th>
								<td class="text-right">@{{subTotal.toLocaleString()}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Descuento:</th>
								<td class="text-right">@{{totaldescuento.toLocaleString()}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Neto:</th>
								<td class="text-right">@{{neto.toLocaleString()}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">IABA:</th>
								<td class="text-right">@{{totalIaba.toLocaleString()}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">I.V.A:</th>
								<td class="text-right">@{{iva.toLocaleString()}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">TOTAL:</th>
								<th class="bg-gray text-right">@{{total.toLocaleString()}}</th>
							</tr>

					</table>
				</div>

			</div>

		 	<button type="submit" form="create" class="btn pull-right">Crear</button>

 	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/notaVenta.js')}}"></script>
@endsection
