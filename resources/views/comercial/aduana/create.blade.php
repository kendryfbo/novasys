@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Aduana</h4>

			@if ($errors->any())

				@foreach ($errors->all() as $error)

					@component('components.errors.validation')
						@slot('errors')
							{{$error}}
						@endslot
					@endcomponent

				@endforeach

			@endif

		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form-horizontal -->
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarAduana')}}">

				{{ csrf_field() }}

        <div class="form-group">
          <label class="control-label col-lg-1" >RUT:</label>
          <div class="col-lg-2">
            <input type="text" class="form-control input-sm" name="rut" placeholder="Rut del Cliente..." value="{{ Input::old('rut') ? Input::old('rut') : '' }}" required>
          </div>
        </div>

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

					<label class="control-label col-lg-1" >Ciudad:</label>
					<div class="col-lg-2">
            <input type="text" class="form-control input-sm" name="ciudad" placeholder="ciudad..." value="{{ Input::old('ciudad') ? Input::old('ciudad') : '' }}" required>
					</div>

					<label class="control-label col-lg-1" >Comuna:</label>
					<div class="col-lg-2">
            <input type="text" class="form-control input-sm" name="comuna" placeholder="comuna..." value="{{ Input::old('comuna') ? Input::old('comuna') : '' }}" required>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Tipo:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="tipo" required>
							<option value="">Seleccionar Tipo de Aduana...</option>
							@foreach ($tipos as $tipo)
								<option value="{{$tipo->descripcion}}">{{$tipo->descripcion}}</option>
							@endforeach
						</select>
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
   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
