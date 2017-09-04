@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Cliente Nacional</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form -->
			<form id="create" class="form-horizontal" method="post" action="{{route('clientesNacionales.store')}}">

				{{ csrf_field() }}

				<!-- form-horizontal -->
				<div class="form-horizontal">

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
					<div class="form-goup">

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2" >R.U.T:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control input-sm input-sm" name="rut" v-model="rut" @change="updateRutNum" placeholder="Rut del Cliente..." value="{{ Input::old('rut') ? Input::old('rut') : '' }}" pattern="^([0-9]+-[0-9K])$" required>
							<input type="hidden" class="form-control input-sm" name="rut_num" v-model="rut_num" value="{{ Input::old('rut_num') ? Input::old('rut_num') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Descripcion:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Giro:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="giro" placeholder="Giro..." value="{{ Input::old('giro') ? Input::old('giro') : '' }}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-2" >Lista de Precio:</label>
						<div class="col-lg-3">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="lista" required>
								<option value="">Seleccionar Lista de precios...</option>
								@foreach ($listasPrecios as $lista)
									<option {{ Input::old('lista') == $lista->id ? 'selected':'' }} value="{{$lista->id}}">{{$lista->descripcion}}</option>
								@endforeach
							</select>
						</div>

						<label class="control-label col-lg-1" >Canal:</label>
						<div class="col-lg-2">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="canal" required>
								<option value="">Seleccionar Canal...</option>
								@foreach ($canales as $canal)
									<option {{ Input::old('canal') == $canal->id ? 'selected':'' }} value="{{$canal->id}}">{{$canal->descripcion}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Forma Pago:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="formaPago" required>
								<option value="">Seleccionar Forma Pago...</option>
								@foreach ($formasPago as $formaPago)
									<option {{ Input::old('formaPago') == $formaPago->id ? 'selected':'' }} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Region:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="region" v-model="region" @change="getProvincias" required>
								<option value="">Seleccionar Region...</option>
								@foreach ($regiones as $region)
									<option value="{{$region->id}}">{{$region->descripcion}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Provincia:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="provincia" v-model="provincia" @change="getComunas" required>
								<option value="">Seleccionar provincia...</option>
									<option v-for="provincia in provincias" v-bind:value="provincia.id" >@{{provincia.descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Comuna:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="comuna" required>
								<option value="">Seleccionar Comuna...</option>
								<option v-for="comuna in comunas" :value="comuna.id" >@{{comuna.descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Direccion:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion de Cliente..." value="{{ Input::old('direccion') ? Input::old('direccion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2" >Vendedor:</label>
						<div class="col-lg-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default btn-sm" name="vendedor">
								<option value="">Seleccionar Vendedor...</option>
								@foreach ($vendedores as $vendedor)
									<option {{ Input::old('vendedor') == $vendedor->id ? 'selected':'' }} value="{{$vendedor->id}}">{{$vendedor->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-2">fono:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{ Input::old('fono') ? Input::old('fono') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">fax:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm " name="fax" placeholder="numero de Fax..." value="{{ Input::old('fax') ? Input::old('fax') : '' }}" >
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-2">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" style="width:230px" name="contacto" placeholder="Persona de Contacto..." value="{{ Input::old('contacto') ? Input::old('contacto') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">Cargo:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" style="width:230px" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{ Input::old('cargo') ? Input::old('cargo') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">email:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" style="width:230px" name="email" placeholder="Email de Persona de Contacto..." value="{{ Input::old('email') ? Input::old('email') : '' }}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-2">Activo:</label>
						<div class="col-lg-4">
							<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
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
   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script>
var provincias = [];
var provincia = '';
var comunas = [];
var comuna = '';
var cliente = '';
var sucursales = '';
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/clienteNacional.js')}}"></script>
@endsection
