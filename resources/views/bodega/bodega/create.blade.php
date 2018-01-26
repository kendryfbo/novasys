@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion de bodega</h4>
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

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarBodega')}}">

				{{ csrf_field() }}

                <h5>Documento</h5>

                <!-- form-group -->
                <div class="form-group">

        			<label class="control-label col-lg-1">Descripcion:</label>
        			<div class="col-lg-5">
        				<input class="form-control input-sm" type="text" name="descripcion" placeholder="Nombre de bodega..." required>
        			</div>


                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Bloques/Racks:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="bloque" type="number" min="1" value="1" required>
                    </div>

                    <label class="control-label col-lg-1">Columnas:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="columna" type="number" min="1" value="1" required>
                    </div>


                    <label class="control-label col-lg-1">Estantes:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="estante" type="number" min="1" value="1" required>
                    </div>

                </div>
                <!-- /form-group -->
                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Tamaño Posiciones:</label>
                    <div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="medida" required>
			              <option value=""></option>
										@foreach ($medidas as $medida)
											<option {{Input::old('medida') ? 'selected':''}} value="{{$medida->id}}">{{$medida->descripcion}}</option>
										@endforeach
			            </select>
                    </div>

                </div>
                <!-- /form-group -->
                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Activo:</label>
                    <div class="col-lg-4">
                        <input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
                    </div>

                </div>
                <!-- /form-group -->

            </form>
            <!-- /form -->

        </div>
        <!-- /box-body -->

        <!-- box-footer -->
        <div class="box-footer">
            <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
        </div>
        <!-- /box-footer -->
    </div>
    <!-- /box -->


@endsection

@section('scripts')
@endsection
