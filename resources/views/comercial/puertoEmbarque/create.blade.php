@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Puerto de Embarque</h4>

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
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarPuertoEmbarque')}}">

				{{ csrf_field() }}

		        <div class="form-group">
		          <label class="control-label col-lg-1" >Nombre:</label>
		          <div class="col-lg-3">
		            <input type="text" class="form-control input-sm" name="nombre" placeholder="Nombre del puerto..." value="{{ Input::old('nombre')}}" required>
		          </div>
		        </div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Tipo:</label>
					<div class="col-lg-5">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default btn-sm" name="tipo" required>
							<option value="">Seleccionar tipo de puerto</option>
							@foreach ($mediosTransporte as $tipo)
								<option {{ Input::old('tipo') == $tipo->descripcion ? 'selected':'' }} value="{{ $tipo->descripcion }}">{{ $tipo->descripcion }}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-lg-1" >Direccion:</label>
					<div class="col-lg-5">
						<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion del Puerto..." value="{{ Input::old('direccion')}}" required>
					</div>
				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Comuna:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="comuna" placeholder="comuna..." value="{{ Input::old('comuna')}}" required>
					</div>

					<label class="control-label col-lg-1" >Ciudad:</label>
					<div class="col-lg-2">
            			<input type="text" class="form-control input-sm" name="ciudad" placeholder="ciudad..." value="{{ Input::old('ciudad')}}" required>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Fono:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="fono" placeholder="Telefono..." value="{{Input::old('fono')}}" required>
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
