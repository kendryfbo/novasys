@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Modificar Cliente Nacional</h4>
		</div>
		<!-- /box-header -->
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#cliente">Cliente</a></li>
		  <li><a data-toggle="tab" href="#sucursales">Sucursales</a></li>
		</ul>
		<!-- tab-content -->
		<div class="tab-content">
			<!-- tab-panel -->
  			<div id="cliente" class="tab-pane fade in active">
				<!-- box-body -->
				<div class="box-body">
					<!-- form -->
					<form  id="create" method="post" action="{{route('actualizarClientesNacionales', ['cliente' => $cliente->id])}}">
						{{ method_field('PUT') }}
						{{ csrf_field() }}

						<!-- form-horizontal -->
						<div class="form-horizontal">

							<div class="form-group">
								<label class="control-label col-sm-2" >R.U.T:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control input-sm" name="rut" v-model="rut" @keyup="updateRutNum($event)" placeholder="Rut del Cliente..." value="{{ $cliente->rut }}" pattern="^([0-9]+-[0-9K])$" required readonly>
									<input type="hidden" class="form-control input-sm" name="rut_num" v-model="rut_num" value="{{ $cliente->rut_num }}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Descripcion:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{ $cliente->descripcion }}" required readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Giro:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="giro" placeholder="Giro..." value="{{ $cliente->giro }}" required>
								</div>
							</div>

							<div class="form-group">

								<label class="control-label col-sm-2" >Lista de Precios:</label>
								<div class="col-sm-3">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="lista" required>
										<option value="">Seleccionar Lista de precios...</option>
										@foreach ($listasPrecios as $lista)
											<option {{$cliente->lp_id == $lista->id ? 'selected':''}} value="{{$lista->id}}">{{$lista->descripcion}}</option>
										@endforeach
									</select>
								</div>

								<label class="control-label col-sm-1" >Canal:</label>
								<div class="col-sm-2">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="canal" required>
										<option value="">Seleccionar Canal...</option>
										@foreach ($canales as $canal)
											<option {{$cliente->canal_id == $canal->id ? 'selected':''}} value="{{$canal->id}}">{{$canal->descripcion}}</option>
										@endforeach
									</select>
								</div>

							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Forma Pago:</label>
								<div class="col-sm-4">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="formaPago" required>
										<option value="">Seleccionar Forma Pago...</option>
										@foreach ($formasPago as $formaPago)
											<option {{ $cliente->fp_id == $formaPago->id ? 'selected':'' }} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Region:</label>
								<div class="col-sm-4">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="region" v-model="region" @change="getProvincias" required>
										<option value="">Seleccionar Region...</option>
										@foreach ($regiones as $region)
											<option value="{{$region->id}}">{{$region->descripcion}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Provincia:</label>
								<div class="col-sm-4">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="provincia" v-model="provincia" @change="getComunas" required>
										<option value="">Seleccionar provincia...</option>
											<option v-for="provincia in provincias" v-bind:value="provincia.id" >@{{provincia.descripcion}}</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Comuna:</label>
								<div class="col-sm-4">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="comuna" v-model="comuna" required>
										<option value="">Seleccionar Comuna...</option>
										<option v-for="comuna in comunas" :value="comuna.id" >@{{comuna.descripcion}}</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Direccion:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion de Cliente..." value="{{ $cliente->direccion }}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" >Vendedor:</label>
								<div class="col-sm-4">
									<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="vendedor">
										<option value="0">Seleccionar Vendedor...</option>
										@foreach ($vendedores as $vendedor)
											<option value="{{$vendedor->id}}" {{$vendedor->id == $cliente->vendedor_id ? 'selected' : '' }}>{{$vendedor->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>

						</div>
						<!-- /form-horizontal -->
						<!-- form-inline -->
						<div class="form-inline col-sm-offset-1">

							<div class="form-group" style=" margin-left: 40px">
								<label>fono:</label>
								<div class="input-group" style=" padding-left: 25px">
									<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{ $cliente->fono }}" required>
								</div>
							</div>

							<div class="form-group">
								<label style=" padding-left: 12px">fax:</label>
								<div class="input-group" style=" padding-left: 25px">
									<input type="text" class="form-control input-sm " name="fax" placeholder="numero de Fax..." value="{{ $cliente->fax }}" >
								</div>
							</div>

						</div>
						<!-- /form-inline -->
						<br>
						<!-- form-inline -->
						<div class="form-inline col-sm-offset-1">

							<div class="form-group" style=" margin-left: 12px">
								<label>Contacto:</label>
								<div class="input-group" style=" padding-left: 25px">
									<input type="text" class="form-control input-sm" style="width:230px" name="contacto" placeholder="Persona de Contacto..." value="{{ $cliente->contacto }}" required>
								</div>
							</div>

							<div class="form-group">
								<label style=" padding-left: 12px">Cargo:</label>
								<div class="input-group" style=" padding-left: 25px">
									<input type="text" class="form-control input-sm" style="width:230px" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{ $cliente->cargo }}" required>
								</div>
							</div>

							<div class="form-group">
								<label style=" padding-left: 12px">email:</label>
								<div class="input-group" style=" padding-left: 25px">
									<input type="email" class="form-control input-sm" style="width:230px" name="email" placeholder="Email de Persona de Contacto..." value="{{ $cliente->email }}" required>
								</div>
							</div>

						</div>
						<!-- /form-inline -->
						<br>
						<!-- form-horizontal -->
						<div class="form-horizontal">

							<div class="form-group">
								<label class="control-label col-sm-2">Activo:</label>
								<div class="col-sm-4">
									<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $cliente->activo ? "checked" : "" }}>
								</div>
							</div>

						</div>
						<!-- /form-horizontal -->
					</form>
					<!-- /form -->
				</div>
				<!-- /box-body -->
				<!-- box-footer -->
				<div class="box-footer">
		   	 		<button type="submit" form="create" class="btn btn-default pull-right">Crear</button>
		   	 	</div>
				<!-- /box-footer -->
			</div>
			<!-- /tab-panel -->

			<!-- tab-panel -->
  			<div id="sucursales" class="tab-pane fade in">
				<!-- box-body -->
				<div class="box-body">
					<!-- form-horizontal -->
					<div id="create-sucursal" class="form-horizontal">

						<div class="form-group">
							<label class="control-label col-sm-2" >Descripcion:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control input-sm" name="descripcion_suc" v-model="descripcion_suc" placeholder="Descripcion de la Sucursal..." required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" >Direccion:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="direccion_suc" v-model="direccion_suc" placeholder="Direccion de la Sucursal..." required>
							</div>
						</div>

					</div>
					<!-- /form-horizontal -->
				</div>
				<!-- /box-body -->
				<!-- box-footer -->
				<div class="box-footer">
		   	 		<button type="button" form="create-sucursal" class="btn pull-right" v-on:click="insertSucursal">Agregar</button>
		   	 	</div>
				<!-- /box-footer -->
				<!-- box-body -->
				<div class="box-body">
					<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>id</th>
								<th>decripcion</th>
								<th>direccion</th>
								<th class="text-center">Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<td colspan="5" class="text-center" v-if="sucursales <= 0">Tabla Sin Datos...</td>
							<tr v-for="(sucursal,key) in sucursales" @click="loadSucursal(sucursal.id)">
								<th class="text-center" v-text="(key+1)"></th>
								<td>@{{ sucursal.id }}</td>
								<td>@{{ sucursal.descripcion }}</td>
								<td>@{{ sucursal.direccion }}</td>
								<td class="text-center">
									<button class="btn btn-sm" type="button" @click="deleteSucursal(sucursal.id)">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /box-body -->
			</div>
			<!-- /tab-panel -->
		</div>
		<!-- /tab-content -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script>

	$('select[name=region]').val({!!$cliente->region_id!!});
	var provincias = {!!$provincias!!};
	var provincia = {!!$cliente->provincia_id!!};
	var comunas = {!!$comunas!!};
	var comuna = {!!$cliente->comuna_id!!};
	var cliente = {!!$cliente->id!!};
	var sucursales = {!!$cliente->sucursal!!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/clienteNacional.js')}}"></script>

@endsection
