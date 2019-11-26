@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creación Plan de Ofertas</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="create" class="form-horizontal" action="{{route('guardarPlanOferta')}}" method="post">
				{{ csrf_field() }}

				<h5></h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Descripción:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="descripcion" required>
					</div>
					<label class="control-label col-lg-1">Fecha Inicio:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_inicio" required>
					</div>
					<label class="control-label col-lg-1">Fecha Término:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_termino" required>
					</div>

				</div>
				<hr>
				<div class="form-group">


					<label class="control-label col-lg-1">Canal:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="canalID">
							<option value=""></option>
							<option v-for="canal in canales" :value="canal.id">@{{canal.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="clientID">
							<option value=""></option>
							<option v-if="cliente.canal_id == canalID" v-for="cliente in clientes" :value="cliente.id">@{{cliente.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemID">
							<option value=""></option>
							<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Descuento :</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="descuento" v-model="descuento" value="">
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
				  	<button class="btn btn-sm btn-danger" type="button" name="button" @click="removeItem(item.item_id)">
					  <i class="fa fa-times-circle" aria-hidden="true"></i>
				  	</button>
				  </td>
				  <td class="text-center">@{{item.cliente}}</td>
				  <td>@{{item.descripcion}}</td>
				  <td class="text-right">@{{item.descuento}}</td>
				</tr>



			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			 <button form="create" class="btn btn-default pull-right" name="button" value="1" type="submit">Crear</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script>
		productos = {!!$productos!!};
		clientesNac = {!!$clientesNac!!};
		canales = {!!$canales!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/comercial/planOfertaCreate.js')}}"></script>
@endsection
