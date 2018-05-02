@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion de Plan de Produccion</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="create" class="form-horizontal" action="{{route('verPlanProduccion')}}" method="post">
				{{ csrf_field() }}

				<h5>Seleccion de Producto Terminado</h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemID">
							<option value=""></option>
							<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

						</select>
					</div>
					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" value="0" min="0" v-model.lazy="cantidad">
					</div>
					<div class="col-lg-1">
						<button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
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
				  <th class="text-center">CODIGO</th>
				  <th class="text-center">DESCRIPCION</th>
				  <th class="text-center">CANTIDAD</th>
				</tr>
			  </thead>

			  <tbody>
				<tr v-if="items <= 0">
					<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
				</tr>

				<tr v-if="items" v-for="(item,key) in items">
				  <td class="text-center">@{{key+1}}</td>
				  <td class="text-center">
				  	<button class="btn btn-sm btn-danger" type="button" name="button" @click="removeItem(item.id)">
					  <i class="fa fa-times-circle" aria-hidden="true"></i>
				  	</button>
				  </td>
				  <td class="text-center">@{{item.codigo}}</td>
				  <td>@{{item.descripcion}}</td>
				  <td class="text-right">@{{item.cantidad.toLocaleString()}}</td>
				</tr>

			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			 <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script>
		productos = {!!$productos!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/adquisicion/planProduccionCreate.js')}}"></script>
@endsection
