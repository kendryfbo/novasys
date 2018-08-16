@extends('layouts.master')

@section('content')
<!-- box -->
<div id="vue-app" class="box box-solid box-default">
	<!-- box-header -->
	<div class="box-header text-center">
		<h4>Crear Fórmula</h4>
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

		<!-- form-horizontal -->
		<form  id="create" class="form-horizontal" method="post" action="{{route('guardarFormula')}}">

			{{ csrf_field() }}

				<div class="form-group">

					<label class="control-label col-lg-1" >Producto:</label>
					<div class="col-lg-5">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="productoID" v-model="productoID" @change="loadProducto" required>
							<option value="">Seleccionar Producto...</option>
							<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>
						</select>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Premezcla:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="premezclaID" required>
							<option value="">Seleccionar Premezcla...</option>
							@foreach ($premezclas as $premezcla)
								<option value="{{$premezcla->id}}">{{$premezcla->descripcion}}</option>
							@endforeach
						</select>
					</div>

					<label class="control-label col-lg-1" >Reproceso:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="reprocesoID" required>
							<option value="">Seleccionar Reproceso...</option>
							@foreach ($reprocesos as $reproceso)
								<option value="{{$reproceso->id}}">{{$reproceso->descripcion}}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Formato:</label>
					<div class="col-lg-3">
						<input type="text" class="form-control input-sm" placeholder="Formato de Producto" :value="formatoDescrip" readonly required>
					</div>
					<label class="control-label col-lg-1" >Batch:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" type="number" min="1" step="0.01" name="cantBatch" v-model.number="cantBatch" placeholder="cantidad x Batch..." @change="calculate" required>
							<span class="input-group-addon">Kg</span>
						</div>
					</div>

				</div>

				<hr>

				<div class="form-group">

					<label class="control-label col-lg-1" >Nivel:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="nivelID" @change="loadNivel">
							<option value="">Seleccionar Nivel...</option>
							<option v-for="nivel in niveles" :value="nivel.id">@{{nivel.descripcion}}</option>
						</select>
					</div>

					<label class="control-label col-lg-1" >Insumo:</label>
					<div class="col-lg-5">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="insumoID" @change="loadInsumo">
							<option value="">Seleccionar Insumo...</option>
							<option v-for="insumo in insumos" :value="insumo.id">@{{insumo.descripcion}}</option>
						</select>
					</div>

				</div>

				<div class="form-group">



					<label class="control-label col-lg-1" >CantXuni:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" type="number" min="0" v-model.number="cantxuni" placeholder="cantidad x Unidad" @change="calculate">
							<span class="input-group-addon">Un/Kg</span>
						</div>
					</div>

					<label class="control-label col-lg-1" >Cant/caja:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" type="number" min="0" name="cantxuni" v-model="cantxcaja" placeholder="cantidad x Caja">
							<span class="input-group-addon">Un/Kg</span>
						</div>
					</div>

					<label class="control-label col-lg-1" >Cant/batch:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" type="number" min="0" name="cantxuni" :value="cantxbatch" placeholder="cantidad x Batch" readonly>
							<span class="input-group-addon">Un/Kg</span>
						</div>
					</div>

					<div class="col-lg-2">
						<button  class="btn btn-sm btn-primary pull-right" type="button" name="button" @click="addItem">Agregar</button>
					</div>

				</div>

				<!-- Items -->
				<select style="display: none;"  name="items[]" multiple required>
					<option v-for="item in items" selected>
						@{{item}}
					</option>
				</select>
				<!-- /items -->

		</form>
		<!-- /form-horizontal -->
	</div>
	<!-- /box-body -->
	<!-- box-body -->
	<div class="box-body">
		<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

		<thead>
			<tr>
				<th class="text-center"></th>
				<th class="text-center">#</th>
				<th class="text-center">DESCRIPCION</th>
				<th class="text-center">Nivel</th>
				<th class="text-center">C. Unidad</th>
				<th class="text-center">C. Caja</th>
				<th class="text-center">C. Batch</th>
			</tr>
		</thead>
		<tbody>
			<tr v-if="items <= 0">
				<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
			</tr>
				<tr v-if="items" v-for="(item,key) in items">
				<td class="text-center">
                    <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(key)"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </td>
				<td class="text-center">@{{key+1}}</td>
				<td>@{{item.descripcion}}</td>
				<td class="text-right">@{{item.nivel.descripcion}}</td>
				<td class="text-right">@{{item.cantxuni}}</td>
				<td class="text-right">@{{item.cantxcaja}}</td>
				<td class="text-right">@{{item.cantxbatch}}</td>
			</tr>
		</tbody>

		</table>
	</div>
	<!-- /box-body -->

	<!-- box-footer -->
	<div class="box-footer">
		<button type="submit" form="create" class="btn btn-default pull-right">Crear</button>
	</div>
	<!-- /box-footer -->
</div>
<!-- /box -->
@endsection

@section('scripts')
<script>
	var productos = {!!$productos!!};
	var niveles = {!!$niveles!!};
	var insumos = {!!$insumos!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/desarrollo/createFormula.js')}}"></script>
@endsection
