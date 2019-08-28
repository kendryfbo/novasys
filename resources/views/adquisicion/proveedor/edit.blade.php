@extends('layouts.masterFinanzas')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Editar Proveedor</h4>



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
			<form  id="create" class="form-horizontal" method="post" action="{{route('actualizarProveedor',['proveedor' => $proveedor->id])}}">

				{{ csrf_field() }}
				{{ method_field('PUT')}}

					<div class="form-group">

						<label class="control-label col-lg-1" >R.U.T.:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="rut" placeholder="Rut del Cliente..." value="{{$proveedor->rut}}" pattern="^([0-9]+-[0-9K])$" readonly required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Descripción:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{$proveedor->descripcion}}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Abreviación:</label>
						<div class="col-lg-1">
							<input type="text" class="form-control input-sm" name="abreviacion" placeholder="Abreviacion del Cliente..." value="{{$proveedor->abreviacion}}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >F. Pago:</label>
						<div class="col-lg-3">
							<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="formaPago" required>
								<option value="">Seleccionar Forma de Pago...</option>
								@foreach ($formasPagos as $formaPago)
									<option {{ $proveedor->fp_id == $formaPago->id ? 'selected':''}} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-1" >Dirección:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion..." value="{{$proveedor->direccion}}" required>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Comuna:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control input-sm" name="comuna" placeholder="Comuna..." value="{{$proveedor->comuna}}" required>
						</div>

						<label class="control-label col-lg-1" >Ciudad:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control input-sm" name="ciudad" placeholder="Ciudad..." value="{{$proveedor->ciudad}}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Giro:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="giro" placeholder="Giro..." value="{{$proveedor->giro}}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="contacto" placeholder="Persona de Contacto..." value="{{$proveedor->contacto}}" required>
						</div>

						<label class="control-label col-lg-1">Cargo:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{$proveedor->cargo}}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Fono:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{$proveedor->fono}}" required>
						</div>

						<label class="control-label col-lg-1">Celular:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="celular" placeholder="Numero de celular..." value="{{$proveedor->celular}}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">E-mail:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" name="email" placeholder="Email de Persona de Contacto..." value="{{$proveedor->email}}" required>
						</div>

						<label class="control-label col-lg-1">Fax:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fax" placeholder="numero de Fax..." value="{{$proveedor->fax}}" >
						</div>

					</div>

					<h5>Contacto Cobranza</h5>

					<div class="form-group">

						<label class="control-label col-lg-1">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="cto_cbrnza" placeholder="Nombre contacto cobranza..." value="{{$proveedor->cto_cbrnza}}">
						</div>

						<label class="control-label col-lg-1">E-mail:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" name="email_cbrnza" placeholder="Email contacto Cobranza..." value="{{$proveedor->email_cbrnza}}">
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-1">Activo:</label>
						<div class="col-lg-2">
							<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $proveedor->activo ? "checked" : "" }}>
						</div>
					</div>

			</form>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="create" class="btn btn-default pull-right">Actualizar</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
@endsection
