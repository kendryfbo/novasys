@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Modificar Aduana</h4>

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
			<form  id="edit" class="form-horizontal" method="post" action="{{route('actualizarAduana', ['aduana' => $aduana->id])}}">

				{{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                  <label class="control-label col-lg-1" >RUT:</label>
                  <div class="col-lg-2">
                    <input type="text" class="form-control input-sm" name="rut" placeholder="Rut del Cliente..." value="{{ $aduana->rut }}" required>
                  </div>
                </div>

				<div class="form-group">
					<label class="control-label col-lg-1" >Descripcion:</label>
					<div class="col-lg-5">
						<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Aduana..." value="{{ $aduana->descripcion }}" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-1" >Direccion:</label>
					<div class="col-lg-6">
						<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion..." value="{{ $aduana->direccion }}" required>
					</div>
				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Ciudad:</label>
					<div class="col-lg-2">
                        <input type="text" class="form-control input-sm" name="ciudad" placeholder="ciudad..." value="{{ $aduana->ciudad }}" required>
					</div>

					<label class="control-label col-lg-1" >Comuna:</label>
					<div class="col-lg-2">
                        <input type="text" class="form-control input-sm" name="comuna" placeholder="comuna..." value="{{ $aduana->comuna }}" required>
					</div>

					<label class="control-label col-lg-1" >Fono:</label>
					<div class="col-lg-2">
                        <input type="text" class="form-control input-sm" name="fono" placeholder="Telefono..." value="{{$aduana->fono }}" required>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1">Activo:</label>
					<div class="col-lg-2">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $aduana->activo ? "checked" : "" }}>
					</div>

				</div>

			</form>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="edit" class="btn pull-right">Modificar</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
