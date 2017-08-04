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
			<form  id="create" method="post" action="{{route('notasVentas.update',$notaVenta->id)}}">

				{{ csrf_field() }}
				<input type="hidden" name="_method" value="put">
				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2" >Centro de Venta:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="centroVenta" required>
								<option value="">Seleccionar Centro de Venta...</option>
								@foreach ($centrosVentas as $centroVenta)
									<option {{ $notaVenta->cv_id == $centroVenta->id ? 'selected' : '' }} value="{{$centroVenta->id}}">{{$centroVenta->descripcion}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Numero:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="numero" placeholder="Numero Nota Venta..." value="{{ $notaVenta->numero }}" required readonly>
						</div>
						<label class="control-label col-lg-1" >Version:</label>
						<div class="col-lg-1">
							<input type="text" class="form-control" name="numero" placeholder="Numero Nota Venta..." value="{{ $notaVenta->version }}" required readonly>
						</div>
					</div>

				</div>
				<!-- /form-horizontal -->
				<hr>
				<h5>Datos</h5>
				<!-- form-inline -->
				<div class="form-inline col-sm-offset-1">

					<div class="form-group">
						<label>Fecha Emision:</label>
						<div class="input-group col-xs-2">
							<input type="date" class="form-control" name="fechaEmision" value="{{ $notaVenta->fecha_emision }}" required>
						</div>
					</div>

					<div class="form-group">
						<label>Fecha Despacho:</label>
						<div class="input-group col-xs-2">
							<input type="date" class="form-control " name="fechaDespacho" value="{{ $notaVenta->fecha_despacho }}" required>
						</div>
					</div>

				</div>
				<!-- /form-inline -->
				<br>
				<!-- form-inline -->
				<div class="form-inline col-sm-offset-1">

					<div class="form-group">
						<label>Cliente:</label>
						<div class="input-group" style="margin-left: 50px">
							<select class="selectpicker" data-width="500" data-live-search="true" data-style="btn-default" name="cliente" v-model="cliente" @change="getData" required readonly>
									<option value="{{$notaVenta->cliente->id}}">{{$notaVenta->cliente->descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group" style="margin-left: 50px">
						<label>Cond. Pago:</label>
						<div class="input-group" style="margin-left: 50px">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="formaPago" required readonly>
									<option value="{{$notaVenta->cond_pago}}">{{$notaVenta->cond_pago}}</option>
							</select>
						</div>
					</div>

				</div>
				<!-- /form-inline -->
				<br>
				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2">Despacho:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="600px" data-live-search="true" data-style="btn-default" name="despacho" v-model="despacho" required>
								<option value="">Direccion de despacho...</option>
								<option v-if="sucursales" v-for="sucursal in sucursales" :value="sucursal.descripcion">@{{sucursal.descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Vendedor:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="vendedor" required>
								<option value="">Seleccionar Vendedor...</option>
								@foreach ($vendedores as $vendedor)
									<option {{ $notaVenta->vendedor_id == $vendedor->id ? 'selected' : '' }} value="{{$vendedor->id}}">{{$vendedor->nombre}}</option>
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
		<hr>
		<div class="container">
			<h5>Detalles</h5>
		</div>

		<!-- box-body -->
		<div class="box-body">

			<!-- form-horizontal -->
			<div class="form-horizontal">

				<div class="form-group">
					<label class="col-sm-1  text-left control-label">Lista Precios:</label>
					<div class="col-sm-4">
						<select class="selectpicker form-control" data-width="auto" data-live-search="true" data-style="btn-default" name="lista" disabled>
							<option v-if="listaDescrip" selected v-bind:value="listaId">@{{listaDescrip}}</option>
						</select>
					</div>
				</div>

				<div class="form-group">

					<label class="col-sm-1 control-label">Producto:</label>
					<div class="col-sm-3">
						<select class="selectpicker form-control" data-width="280" data-live-search="true" data-style="btn-default" name="producto" v-model="producto" @change="loadProducto">
							<option value="">Producto...</option>
							<option v-if="listaDetalle" v-for="detalle in listaDetalle" v-bind:value="detalle.id">@{{detalle.descripcion}}</option>
						</select>
					</div>

					<label class="col-sm-1 control-label">Cantidad:</label>
					<div class="col-sm-1">
						<input class="form-control" type="number" min="0" name="cantidad" v-model="cantidad">
					</div>

					<label class="col-sm-1 control-label">%Dscto:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="descuento" v-model="descuento" disabled>
					</div>

					<label class="col-sm-1 control-label">Precio:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="precio" v-model="precio" disabled>
					</div>

				</div>

				<div class="form-group">
					<div class="col-sm-offset-10 col-sm-2">
						<button class="btn" type="button" @click="removeItem">Borrar</button>
						<button class="btn" type="button" @click="insertItem">Agregar</button>
					</div>
				</div>

			</div>
			<!-- /form-horizontal -->
			<!-- form-horizontal -->
			<div class="form-horizontal">

			</div>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body" style="overflow-y: scroll;max-height:200px;border:1px solid black;">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>descripcion</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Dscto</th>
						<th>total</th>
					</tr>
				</thead>
				<tbody>
					<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
					<tr v-for="(item,key) in items" v-bind:class="[key === select ? 'active' : '']"  @click="loadItem(key)">
						<th class="text-center">@{{key+1}}</th>
						<td>@{{item.codigo}}</td>
						<td>@{{item.descripcion}}</td>
						<td>@{{item.cantidad}}</td>
						<td>@{{item.precio}}</td>
						<td>@{{item.descuento}}</td>
						<td>@{{item.total}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form-horizontal -->
			<div class="form-horizontal">

				<div class="form-group">
					<label class="col-sm-1 control-label">Sub-Total:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="subTotal" v-model.number="subTotal" disabled>
					</div>
					<label class="col-sm-1 control-label">Descuento:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="totaldescuento" v-model.number="totaldescuento" disabled>
					</div>
					<label class="col-sm-1 control-label">Neto:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="totalNeto" v-model.number="neto" disabled>
					</div>
					<label class="col-sm-1 control-label">IABA:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="iaba" v-model.number="totalIaba" disabled>
					</div>
					<label class="col-sm-1 control-label">I.V.A:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="iva" v-model.number="iva" disabled>
					</div>
					<label class="col-sm-1 control-label">Total:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="total" v-model="total" disabled>
					</div>
				</div>

			</div>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->

		<!-- box-footer -->
		<div class="box-footer">
			<div class="form-inline">

				<div class="form-group">
					<label class="control-label">Total Peso Neto:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="peso_neto" v-model.number="totalPesoNeto" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Total Peso Bruto:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="peso_bruto" v-model.number="totalPesoBruto" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Volumen:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="volumen" v-model.number="totalVolumen" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

			</div>

   	 		<button type="submit" form="create" class="btn pull-right">Modificar</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script>
	var cliente = {!! $notaVenta->cliente_id !!};
	var sucursales = {!! $notaVenta->cliente->sucursal !!};
	var despacho = "{!! $notaVenta->despacho !!}";
	var items = {!!$notaVenta->detalle!!};
	var listaId = {!! $notaVenta->cliente->listaPrecio->id !!};
	var listaDescrip = "{!! $notaVenta->cliente->listaPrecio->descripcion !!}";
	var listaDetalle = {!! $notaVenta->cliente->listaPrecio->detalle !!};
	var descuento = {!!$notaVenta->cliente->canal->descuento!!};
	var subtotal = {!! $notaVenta->sub_total !!};
	var descuento = {!! $notaVenta->descuento !!};
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
