@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Cliente Internacional</h4>



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
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarClienteIntl')}}">

				{{ csrf_field() }}

					<div class="form-group">
						<label class="control-label col-lg-1" >Descripcion:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-1" >Direccion:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion..." value="{{ Input::old('direccion') ? Input::old('direccion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Zona:</label>
						<div class="col-lg-3">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="zona" required>
								<option value="">Seleccionar Zona Geografica...</option>
								@foreach ($zonas as $zona)
									<option {{ Input::old('direccion') == $zona->descripcion ? 'selected':''}} value="{{$zona->descripcion}}">{{$zona->descripcion}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Pais:</label>
						<div class="col-lg-2">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="pais_id" required>
								<option value="">Seleccionar pais...</option>
								@foreach ($paises as $pais)
									<option {{ Input::old('pais_id') == $pais->id ? 'selected':''}} value="{{$pais->id}}">{{$pais->nombre}}</option>
								@endforeach
							</select>
						</div>

						<label class="control-label col-lg-1" >Idioma:</label>
						<div class="col-lg-1">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="idioma" required>
								<option value="">idioma...</option>
								@foreach ($idiomas as $idioma)
									<option {{ Input::old('idioma') == $idioma->descripcion ? 'selected':''}} value="{{$idioma->descripcion}}">{{$idioma->descripcion}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >F. Pago:</label>
						<div class="col-lg-2">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formaPago" required>
								<option value="">Seleccionar Forma Pago...</option>
								@foreach ($formasPago as $formaPago)
									<option {{ Input::old('formaPago') == $formaPago->id ? 'selected' : '' }} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
								@endforeach
							</select>
						</div>

						<label class="control-label col-lg-1" >Credito:</label>
						<div class="col-lg-2">
							<div class="input-group">
								<span class="input-group-addon">US$</span>
								<input type="text" class="form-control input-sm" v-model="creditoWithFormat" placeholder="Credito..." value="" @blur="formatCredito" @focus="unFormatCredito" required>
								<input type="hidden" min="0" step="1" class="form-control input-sm" name="credito" v-model="credito" placeholder="Credito..." value="{{ Input::old('credito') ? Input::old('credito') : '' }}" required>
							</div>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Giro:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="giro" placeholder="Giro..." value="{{ Input::old('giro') ? Input::old('giro') : '' }}" required>
						</div>



					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="contacto" placeholder="Persona de Contacto..." value="{{ Input::old('contacto') ? Input::old('contacto') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">Cargo:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{ Input::old('cargo') ? Input::old('cargo') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">fono:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{ Input::old('fono') ? Input::old('fono') : '' }}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">email:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" name="email" placeholder="Email de Persona de Contacto..." value="{{ Input::old('email') ? Input::old('email') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">fax:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fax" placeholder="numero de Fax..." value="{{ Input::old('fax') ? Input::old('fax') : '' }}" >
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-1">Activo:</label>
						<div class="col-lg-2">
							<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
						</div>
					</div>

			</form>
			<!-- /form-horizontal -->
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
</script>

<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/createClienteIntl.js')}}"></script>
@endsection
