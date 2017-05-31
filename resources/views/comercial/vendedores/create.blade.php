@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Vendedor</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form -->
			<form  id="create" method="post" action="{{route('vendedores.store')}}">

				{{ csrf_field() }}
				
				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2" >R.U.T:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="rut" placeholder="Rut del Vendedor..." value="{{ Input::old('rut') ? Input::old('rut') : '' }}" pattern=".{5,10}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Nombre:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="nombre" placeholder="nombre del Vendedor..." value="{{ Input::old('nombre') ? Input::old('nombre') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Iniciales:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="iniciales" placeholder="Iniciales del Vendedor..." value="{{ Input::old('iniciales') ? Input::old('iniciales') : '' }}" required>
						</div>
					</div>

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
