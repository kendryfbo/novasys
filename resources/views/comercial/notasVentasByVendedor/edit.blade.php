@extends('layouts.vendedor')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Modificar Nota de Venta</h4>
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
			<form  id="edit" method="post" action="{{route('actualizarNotaVentaByVendedor',['notaVenta' => $notaVenta->id])}}">

				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<!-- form-horizontal -->
				<div class="form-horizontal">
					<h5>Documento</h5>
					<div class="form-group form-group-sm">
						<label class="control-label col-sm-2" >Centro de Venta:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="centroVenta" required>
							<option value="3">MERCADO NACIONAL S.A.</option>
							</select>
						</div>
					</div>

					<div class="form-group form-group-sm">
						<label class="control-label col-sm-2" >Número:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="numero" placeholder="Número Nota Venta..." value="{{$notaVenta->numero}}" readonly>
						</div>

						<label class="control-label col-sm-1" >Versión:</label>
						<div class="col-sm-1">
							<input type="text" class="form-control" name="version" value="{{ $notaVenta->version + 1 }}" readonly>
						</div>
					</div>

					<h5>Datos</h5>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Fecha Emisión:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control" name="fechaEmision" value="{{$notaVenta->fecha_emision}}" required readonly>
						</div>

						<label class="control-label col-lg-1">Fecha despacho:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control " name="fechaDespacho" value="{{$notaVenta->fecha_despacho}}" required readonly>
						</div>

						<label class="control-label col-lg-1" >O. Compra:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control" name="orden_compra" placeholder="Número..." value="{{ $notaVenta->orden_compra }}" readonly>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Cliente:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="500" data-live-search="true" data-style="btn-default btn-sm" name="cliente" required>
								<option selected value="{{ $notaVenta->cliente->id }}">{{$notaVenta->cliente->descripcion }}</option>
							</select>
						</div>

						<label class="control-label col-lg-2">Cond. Pago:</label>
						<div class="col-lg-2">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="formaPago" required>
								<option selected value="{{ $notaVenta->cond_pago }}" >{{ $notaVenta->cond_pago }}</option>
							</select>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Dirección:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" name="direccion" value="{{$notaVenta->direccion}}" placeholder="direccion facturacion..." readonly>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Despacho:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="600px" data-live-search="true" data-style="btn-default btn-sm" name="despacho" required>
								@foreach ($notaVenta->cliente->sucursal as $sucursal)
									<option {{ $notaVenta->despacho == $sucursal->direccion ? 'selected':'' }} value="{{ $sucursal->direccion }}">{{ $sucursal->descripcion . " - " . $sucursal->direccion }}</option>
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
				<input type="hidden" name="vendedor" value="{{$vendedorID}}" readonly>
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
							<option v-if="listaDetalle" v-for="detalle in listaDetalle" v-bind:value="detalle.producto.id">@{{detalle.producto.descripcion}}</option>
						</select>
					</div>

					<label class="control-label col-lg-1">Cant:</label>
					<div class="col-lg-1">
						<input class="form-control text-right" type="number" min="0" step="1" pattern="0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="cantidad" v-model.number="cantidad">
					</div>

					<label class="control-label col-lg-1">%Dscto:</label>
					<div class="col-lg-1">
						<input class="form-control text-right" type="number" name="descuento" v-model.number="descuento" readonly>
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
						<th class="text-center">Código</th>
						<th class="text-center">Descripción</th>
						<th class="text-center">Cantidad</th>
						<th class="text-center">Precio</th>
						<th class="text-center">Dscto.</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
					<tr v-for="(item,key) in items" v-bind:class="[key === select ? 'active' : '']"  @click="loadItem(key)">
						<th class="text-center">@{{key+1}}</th>
						<td class="text-center">@{{item.codigo}}</td>
						<td>@{{item.descripcion}}</td>
						<td class="text-right">@{{item.cantidad}}</td>
						<td class="text-right">@{{numberFormat(item.precio)}}</td>
						<td class="text-right">@{{item.descuento}}</td>
						<td class="text-right">@{{numberFormat(item.sub_total)}}</td>
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
								<td class="text-right">@{{totalCajas}}</td>
							</tr>


					</table>
				</div>
				<div class=" col-sm-3 col-md-offset-6">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Sub-Total:</th>
								<td class="text-right">@{{numberFormat(subTotal)}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Descuento:</th>
								<td class="text-right">@{{numberFormat(totaldescuento)}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Neto:</th>
								<td class="text-right">@{{numberFormat(neto)}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">IABA:</th>
								<td class="text-right">@{{numberFormat(totalIaba)}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">I.V.A:</th>
								<td class="text-right">@{{numberFormat(iva)}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">TOTAL:</th>
								<th class="bg-gray text-right">@{{numberFormat(total)}}</th>
							</tr>

					</table>
				</div>

			</div>

		 	<button type="submit" form="edit" class="btn pull-right">Modificar</button>

 	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection


@section('scripts')
<script>
	var items = {!! $notaVenta->detalle->toJson() !!};
	var listaId = {!! $notaVenta->cliente->listaPrecio->id !!};
	var listaDescrip = "{!! $notaVenta->cliente->listaPrecio->descripcion !!}";
	var listaDetalle = {!! $notaVenta->cliente->listaPrecio->detalle !!};
	var descuento = {!!$notaVenta->cliente->canal->descuento!!};
	var subTotal = {!! $notaVenta->sub_total !!};
	var neto = {!! $notaVenta->neto !!};
	var iva = {!! $notaVenta->iva !!};
	var iaba = {!! $notaVenta->iaba !!};
	var total = {!! $notaVenta->total !!};
	var peso_neto = {!! $notaVenta->peso_neto !!};
	var peso_bruto = {!! $notaVenta->peso_bruto !!};
	var volumen = {!! $notaVenta->volumen !!};

</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/notaVentaEdit.js')}}"></script>
@endsection
