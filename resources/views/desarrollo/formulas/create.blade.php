@extends('layouts.master')

@section('content')

<div id="vue-app" class="container box box-gray">

	<div class="box-header with-border">
	  <h3 class="box-title">Crear Formula</h3>
	</div>
	<!-- /.box-header -->
	<!-- box-body -->
	<div class="box-body">
		<div class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-1">Producto:</label>
				<div class="col-sm-6">
					<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="producto" v-model="producto" @change="getFormula" required>
							<option value="">Seleccionar Producto...</option>
							@foreach ($productos as $producto)
								<option value="{{$producto->id}}">{{$producto->descripcion}}</option>
							@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group" style="padding-left:13px">
				<label style=" padding-right: 25px">Formato:</label>
				<div class="input-group" style=" padding-right: 25px">
					<input class="form-control" type="text" class="form-control" name="formato" v-model="formato" disabled required>
				</div>
			</div>
			<div class="form-group">
				<label style=" padding-right: 25px">tamaño del Batch:</label>
				<div class="input-group" style=" padding-right: 25px">
					<input class="form-control" type="number" min="0" class="form-control" name="batch" v-model.number="batch" placeholder="cantidad x Batch..." required>
					<span class="input-group-addon">Kg</span>
				</div>
			</div>
		</div>
		<br>
		<!-- .inner Box -->
		<div v-if="producto" class="box box-default">
			<div class="box-header">
				<div class="form-inline">
					<div class="form-group">
						<label>Nivel:</label>
						<select class="selectpicker" data-width="110px" data-live-search="true" data-style="btn-default" name="nivel" v-model="nivel">
							<option value="">Nivel...</option>
							@foreach ($niveles as $nivel)
								<option value="{{$nivel->id}}">{{$nivel->descripcion}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Familia:</label>
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="familia" v-model="familia" @change="getInsumos">
								<option value="">Seleccionar Familia...</option>
								@foreach ($familias as $familia)
									<option value="{{$familia->id}}">{{$familia->descripcion}}</option>
								@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Insumo:</label>
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="insumo" v-model="insumo" @change="updateInsumo">
							<option value="">Seleccionar Insumo...<i v-if="loadingInsumo" class="fa fa-spinner fa-pulse fa-lg fa-fw"></i></option>
							<option v-for="insumo in insumos" :value="insumo.id">@{{ insumo.descripcion }}</option>
						</select>
					</div>
					<div class="form-group">
						<label>Cant x Unidad:</label>
						<div class="input-group" style=" padding-right: 25px">
							<input class="form-control" type="number" min="0" step="any" class="form-control" name="cantxuni" v-model.number="cantxuni" @keyup="calcular" placeholder="cantidad x Unidad...">
							<span class="input-group-addon">Un / Kg</span>
						</div>
					</div>
					<div class="form-group">
							<button  class="btn btn-sm btn-primary" type="button" name="button" v-on:click="storeInsumo">Agregar</button>
							<i v-if="loadingItem" class="fa fa-spinner fa-pulse fa-lg fa-fw"></i>

					</div>
				</div>
				<br>
				<div class="form-inline">
					<div class="form-group">
						<label>Cant x Caja:</label>
						<div class="input-group" style=" padding-right: 25px">
							<input class="form-control" type="number" min="0" class="form-control" name="cantxcaja" v-model="cantxcaja" placeholder="0" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Cant x Batch:</label>
						<div class="input-group" style=" padding-right: 25px">
							<input class="form-control" type="number" min="0" class="form-control" name="cantxbatch" v-model="cantxbatch" placeholder="0" readonly>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>codigo</th>
							<th>decripcion</th>
							<th>Cant.Envase</th>
							<th>Cant.Caja</th>
							<th>Cant.Batch</th>
							<th>Nivel</th>
							<th class="text-center">Eliminar</th>
						</tr>
					</thead>
					<tbody>
						<td colspan="8" class="text-center" v-if="items <= 0" >Tabla sin Datos...</td>
						<tr v-for="(item,key) in items">
							<th class="text-center">@{{ key + 1 }}</th>
							<td>@{{ item.insumo_cod }}</td>
							<td>@{{ item.insumo_descrip }}</td>
							<td>@{{ item.cantxuni }}</td>
							<td>@{{ item.cantxcaja }}</td>
							<td>@{{ item.cantxbatch }}</td>
							<td>@{{ item.nivel }}</td>
							<td class="text-center">
								<button class="btn btn-sm" type="button" name="button">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<!-- form start -->
				<form id="create" method="post" action="{{route('generarFormula')}}">
					{{ csrf_field() }}
					<input type="hidden" name="formula" v-bind:value="formulaId">
					<button class="btn btn-default" type="submit" name="generar">Generar Formula</button>
				</form>
			</div>
			<!-- /.box-footer -->
		</div>
		<!-- /.inner box -->
	</div>
	<!--/.box-body -->
	<select style="visibility:hidden"  name="items[]"  form="create" multiple>
		<option></option>
	</select>
</div>

@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/desarrollo/formula.js')}}"></script>
@endsection
