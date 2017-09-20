@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Cliente Internacional</h4>



		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- div-horizontal -->
			<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-lg-1" >Descripcion:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control input-sm" name="descripcion" value="{{ $cliente->descripcion }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-1" >Direccion:</label>
						<div class="col-lg-6">
							<input type="text" class="form-control input-sm" name="direccion" value="{{ $cliente->direccion }}" readonly>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Zona:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control input-sm" name="zona" value="{{ $cliente->zona }}" readonly>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Pais:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="pais" value="{{ $cliente->pais }}" readonly>
						</div>

						<label class="control-label col-lg-1" >Idioma:</label>
						<div class="col-lg-1">
							<input type="text" class="form-control input-sm" name="idioma" value="{{ $cliente->idioma }}" readonly>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >F. Pago:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="formaPago" value="{{ $cliente->formaPago->descripcion }}" readonly>
						</div>

						<label class="control-label col-lg-1" >Credito:</label>
						<div class="col-lg-2">
							<div class="input-group">
								<span class="input-group-addon">US$</span>
								<input type="text" class="form-control input-sm" value="{{ number_format($cliente->credito,2,',','.') }}" readonly>
							</div>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Giro:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="giro" value="{{ $cliente->giro }}" readonly>
						</div>



					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Contacto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="contacto" value="{{ $cliente->contacto }}" readonly>
						</div>

						<label class="control-label col-lg-1">Cargo:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="cargo" value="{{ $cliente->cargo }}" readonly>
						</div>

						<label class="control-label col-lg-1">fono:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{ $cliente->fono }}" readonly>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">email:</label>
						<div class="col-lg-2">
							<input type="email" class="form-control input-sm" name="email" placeholder="Email de Persona de Contacto..." value="{{ $cliente->email }}" readonly>
						</div>

						<label class="control-label col-lg-1">fax:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="fax" value="{{ $cliente->fax }}" readonly>
						</div>

					</div>

			</div>
			<!-- /div-horizontal -->
		</div>
		<!-- /box-body -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
