@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion Pallet Produccion</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletProduccion')}}">

				{{ csrf_field() }}

                <h5>Pallet</h5>

                <!-- form-group -->
                <div class="form-group">


                    <div class="col-lg-offset-1 col-lg-2">
                        {!!$barCode!!}
                    </div>

					<div class="col-lg-1 col-lg-offset-7">
						<a class="btn btn-sm btn-default" href="{{route('etiquetaPalletProduccion',['pallet' => $pallet->id])}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
					</div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Nº Pallet:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="numero" type="number" value="{{$pallet->numero}}" required readonly>
                    </div>

                    <label class="control-label col-lg-1">Tamaño:</label>
        			<div class="col-lg-1">
						<input class="form-control input-sm" name="medida" type="text" value="{{$pallet->medida->descripcion}}" required readonly>
        			</div>


                </div>
                <!-- /form-group -->

				<!-- form-group -->
                <div class="form-group">
				{{--
                    <label class="control-label col-lg-1">Condicion:</label>
        			<div class="col-lg-3">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="codicion" v-model="condicion">
                             <option value=""> </option>
                        @foreach ($condiciones as $condicion)
                             <option {{Input::old('codicion') ? 'selected':''}} value="{{$condicion->id}}">{{$condicion->descripcion}}</option>
                        @endforeach
                        </select>
        			</div>

                    <label class="control-label col-lg-1">Opcion:</label>
        			<div class="col-lg-2">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="opcion" :required="condicion != ''">
                             <option value=""> </option>
                        @foreach ($opciones as $opcion)
                             <option {{Input::old('opcion') ? 'selected':''}} value="{{$opcion->id}}">{{$opcion->descripcion}}</option>
                        @endforeach
                        </select>
        			</div>
				--}}
                </div>
                <!-- /form-group -->


            </form>
            <!-- /form -->

        </div>
        <!-- /box-body -->

        <!-- box-footer -->
        <div class="box-footer">

			<h5>Detalles</h5>
          <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

            <thead>

              <tr>
                <th class="text-center">#</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">CANTIDAD</th>
              </tr>

            </thead>

            <tbody>
				@foreach ($pallet->detalles as $detalle)

					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-left">{{$detalle->producto->descripcion}}</td>
						<td class="text-right">{{$detalle->cantidad}}</td>
					</tr>

				@endforeach

            </tbody>

          </table>

			<div class="row">

				<div class=" col-sm-3 pull-right">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

						<tr>
						<th class="bg-gray text-right">TOTAL:</th>
						<th class="text-right">{{$pallet->detalles->sum('cantidad')}}</th>
						</tr>

					</table>
				</div>

			</div>
          <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>

        </div>
        <!-- /box-footer -->
    </div>
    <!-- /box -->


@endsection

@section('scripts')
@endsection
