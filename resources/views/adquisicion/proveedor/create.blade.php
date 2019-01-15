@extends('layouts.masterFinanzas')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Proveedor</h4>
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
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarProveedor')}}">

				{{ csrf_field() }}

					<div class="form-group">

						<label class="control-label col-lg-1" >R.U.T:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="rut" placeholder="Rut del Cliente..." value="{{ Input::old('rut') ? Input::old('rut') : '' }}" pattern="^([0-9]+-[0-9K])$" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Descripcion:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Abreviacion:</label>
						<div class="col-lg-1">
							<input type="text" class="form-control input-sm" name="abreviacion" placeholder="Abreviacion del Cliente..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >F. Pago:</label>
						<div class="col-lg-3">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formaPago" required>
								<option value="">Seleccionar Forma de Pago...</option>
								@foreach ($formasPagos as $formaPago)
									<option {{ Input::old('formaPago') == $formaPago->id ? 'selected':''}} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-1" >Direccion:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion..." value="{{ Input::old('direccion') ? Input::old('direccion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Comuna:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control input-sm" name="comuna" placeholder="Comuna..." value="{{ Input::old('comuna') ? Input::old('comuna') : '' }}" required>
						</div>

						<label class="control-label col-lg-1" >Ciudad:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control input-sm" name="ciudad" placeholder="Ciudad..." value="{{ Input::old('ciudad') ? Input::old('ciudad') : '' }}" required>
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

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">fono:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{ Input::old('fono') ? Input::old('fono') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">Celular:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="celular" placeholder="Numero de celular..." value="{{ Input::old('celular') ? Input::old('celular') : '' }}" required>
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

					<h5>Contacto Cobranza</h5>

					<div class="form-group">

						<label class="control-label col-lg-1">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="cto_cbrnza" placeholder="Nombre contacto cobranza..." value="{{ Input::old('cto_cbrnza') ? Input::old('cto_cbrnza') : '' }}">
						</div>

						<label class="control-label col-lg-1">Email:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" name="email_cbrnza" placeholder="Email contacto Cobranza..." value="{{ Input::old('email_cbrnza') ? Input::old('email_cbrnza') : '' }}">
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
@endsection
