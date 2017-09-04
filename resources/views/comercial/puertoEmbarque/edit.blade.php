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
			<form  id="edit" class="form-horizontal" method="post" action="{{route('actualizarPuertoEmbarque', ['puertoEmbarque' => $puerto->id])}}">

				{{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">

                  <label class="control-label col-lg-1" >Nombre:</label>
                  <div class="col-lg-2">
                    <input type="text" class="form-control input-sm" name="nombre" placeholder="Nombre de Puerto..." value="{{ $puerto->nombre }}" required>
                  </div>

                </div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Tipo:</label>
					<div class="col-lg-5">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default btn-sm" name="tipo" required>
							<option value="">Seleccionar tipo de puerto</option>
							@foreach ($mediosTransporte as $tipo)
								<option {{ $puerto->tipo == $tipo->descripcion ? 'selected':'' }} value="{{ $tipo->descripcion }}">{{ $tipo->descripcion }}</option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-lg-1" >Direccion:</label>
					<div class="col-lg-5">
						<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion del Puerto..." value="{{ $puerto->direccion }}" required>
					</div>
				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Comuna:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="comuna" placeholder="comuna..." value="{{ $puerto->comuna }}" required>
					</div>

					<label class="control-label col-lg-1" >Ciudad:</label>
					<div class="col-lg-2">
            			<input type="text" class="form-control input-sm" name="ciudad" placeholder="ciudad..." value="{{ $puerto->ciudad }}" required>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1" >Fono:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="fono" placeholder="Telefono..." value="{{ $puerto->fono }}" required>
					</div>

				</div>


				<div class="form-group">

					<label class="control-label col-lg-1">Activo:</label>
					<div class="col-lg-2">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $puerto->activo ? "checked" : "" }}>
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
