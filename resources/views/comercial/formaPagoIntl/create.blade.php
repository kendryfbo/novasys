@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Condicion de Pago Internacional</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form -->
			<form  id="create" method="post" action="{{route('guardarFormaPagoIntl')}}">

				{{ csrf_field() }}

				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2" >Descripcion:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="descripcion" placeholder="Descripcion condicion..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Dias:</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="dias" placeholder="dias de condicion..." value="{{ Input::old('dias') ? Input::old('dias') : '' }}" required>
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
