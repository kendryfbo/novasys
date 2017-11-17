@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion de Pallet Manual</h4>
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

			<div class="form-horizontal">

				<div class="form-group">

					<label class="col-lg-2 text-right">Materia Prima:</label>
					<div class="col-lg-6 btn-group btn-group-sm">
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Nuevo</a>
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Existente</a>
					</div>

				</div>

				<div class="form-group">

					<label class="col-lg-2 text-right">Producto Terminado:</label>
					<div class="col-lg-6 btn-group btn-group-sm">
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Nuevo</a>
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Existente</a>
					</div>

				</div>

				<div class="form-group">

					<label class="col-lg-2 text-right">Premezcla:</label>
					<div class="col-lg-6 btn-group btn-group-sm">
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Nuevo</a>
					  <a href="" class="btn btn-sm btn-default">Ingreso Pallet Existente</a>
					</div>

				</div>

			</div>


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
