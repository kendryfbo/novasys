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
			<form  id="create" method="post" action="{{route('clientesNacionales.store')}}">

				{{ csrf_field() }}

				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2" >R.U.T:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="rut" v-model="rut" @keyup="updateRutNum($event)" placeholder="Rut del Cliente..." value="{{ Input::old('rut') ? Input::old('rut') : '' }}" pattern="^([0-9]+-[0-9K])$" required>
							<input type="hidden" class="form-control" name="rut_num" v-model="rut_num" value="{{ Input::old('rut_num') ? Input::old('rut_num') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Descripcion:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="descripcion" placeholder="Nombre del Cliente..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Giro:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="giro" placeholder="Giro..." value="{{ Input::old('giro') ? Input::old('giro') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Region:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="region" v-model="region" @change="getProvincias" required>
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
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="provincia" v-model="provincia" @change="getComunas" required>
								<option value="">Seleccionar provincia...</option>
									<option v-for="provincia in provincias" v-bind:value="provincia.id" >@{{provincia.descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Comuna:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="comuna" required>
								<option value="">Seleccionar Comuna...</option>
								<option v-for="comuna in comunas" :value="comuna.id" >@{{comuna.descripcion}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Direccion:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="direccion" placeholder="Direccion de Cliente..." value="{{ Input::old('direccion') ? Input::old('direccion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Vendedor:</label>
						<div class="col-sm-4">
							<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="vendedor">
								<option value="">Seleccionar Vendedor...</option>
								@foreach ($vendedores as $vendedor)
									<option value="{{$vendedor->id}}">{{$vendedor->nombre}}</option>
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
							<input type="text" class="form-control" name="fono" placeholder="Numero de Tlf..." value="{{ Input::old('fono') ? Input::old('fono') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label style=" padding-left: 12px">fax:</label>
						<div class="input-group" style=" padding-left: 25px">
							<input type="text" class="form-control " name="fax" placeholder="numero de Fax..." value="{{ Input::old('fax') ? Input::old('fax') : '' }}" required>
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
							<input type="text" class="form-control" style="width:230px" name="contacto" placeholder="Persona de Contacto..." value="{{ Input::old('contacto') ? Input::old('contacto') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label style=" padding-left: 12px">Cargo:</label>
						<div class="input-group" style=" padding-left: 25px">
							<input type="text" class="form-control" style="width:230px" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{ Input::old('cargo') ? Input::old('cargo') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label style=" padding-left: 12px">email:</label>
						<div class="input-group" style=" padding-left: 25px">
							<input type="email" class="form-control" style="width:230px" name="email" placeholder="Email de Persona de Contacto..." value="{{ Input::old('email') ? Input::old('email') : '' }}" required>
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
