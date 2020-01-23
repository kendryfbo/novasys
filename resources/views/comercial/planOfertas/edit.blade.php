@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Edición	Plan de Ofertas</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="edit" class="form-horizontal" action="{{route('actualizarPlanOferta',['id' => $planOfertas->id])}}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<h5></h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Descripción:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="descripcion" value="{{$planOfertas->descripcion}}" required>
					</div>
					<label class="control-label col-lg-1">Fecha Inicio:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_inicio" value="{{$planOfertas->fecha_inicio}}" required>
					</div>
					<label class="control-label col-lg-1">Fecha Término:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_termino" value="{{$planOfertas->fecha_termino}}" required>
					</div>

				</div>
				<hr>
				<div class="form-group">

					<label class="control-label col-lg-1">Canal:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="nombre_cliente" v-model="canalID">
							<option value=""></option>
							<option v-for="canal in canales" :value="canal.id">@{{canal.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="nombre_cliente" v-model="clientID">
							<option value=""></option>
							<option v-if="cliente.canal_id == canalID" v-for="cliente in clientes" :value="cliente.id">@{{cliente.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="nombre_producto" v-model="itemID">
							<option value=""></option>
							<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Descuento :</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" name="descuento" v-model="descuento" min="0" value="">
					</div>

					<div class="col-lg-1">
						<button id="addItem" class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
					</div>



				</div>

				<div class="form-group">

					<!-- Items -->
					<select style="display: none;"  name="items[]" multiple required>
						<option v-for="item in items" selected>
							@{{item}}
						</option>
					</select>
					<!-- /items -->

				</div>

			</form>
		</div>

		<div class="box-body">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

			  <thead>
				<tr>
					<th class="text-center">#</th>
				  <th class="text-center"></th>
				  <th class="text-center">CLIENTE</th>
				  <th class="text-center">PRODUCTO</th>
				  <th class="text-center">DESCUENTO</th>
				</tr>
			  </thead>

			  <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>

				<tr v-if="items" v-for="(item,key) in items">
				  <td class="text-center">@{{key+1}}</td>
				  <td class="text-center">
				  	<button class="btn btn-sm btn-danger" type="button" name="button" @click="removeItem(key)">
					  <i class="fa fa-times-circle" aria-hidden="true"></i>
				  	</button>
				  </td>
					<td class="text-left">@{{item.nombre_cliente}}</td>
				  <td class="text-left">@{{item.nombre_producto}}</td>
				  <td class="text-center">@{{item.descuento}}</td>
				</tr>

			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			 <button form="edit" class="btn btn-default pull-right" name="button" value="1" type="submit">Actualizar</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script>
	var productos = {!!$productos!!};
	var clientesNac = Object.values({!!$clientesNac!!});
	var canales = {!!$canales!!};
	var items = {!!$planOfertas->detalles->toJson()!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/comercial/planOfertaEdit.js')}}"></script>
@endsection
