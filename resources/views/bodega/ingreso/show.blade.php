@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingreso Orden Compra</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarIngOC')}}">

				{{ csrf_field() }}

                <h5>Datos</h5>



                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Numero:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="numero" type="text" value="{{$ingreso->numero}}" required readonly>
                    </div>
                    <label class="control-label col-lg-1">Fecha:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="fecha" type="date" value="{{$ingreso->fecha_ing}}" required readonly>
                    </div>
					<label class="control-label col-lg-1">Status:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" name="tipo" type="text" value="{{$ingreso->status->descripcion}}" required readonly>
					</div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

					<label class="control-label col-lg-1">Tipo Ingreso:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" name="tipo" type="text" value="{{$ingreso->tipo->descripcion}}" required readonly>
					</div>
					<label class="control-label col-lg-1">Numero:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" name="tipo" type="text" value="{{$ingreso->item_id}}" required readonly>
					</div>


                </div>
                <!-- /form-group -->

                <h5>Items</h5>

            </form>
            <!-- /form -->

        </div>
        <!-- /box-body -->

        <!-- box-footer -->
        <div class="box-footer">

          <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

            <thead>
				<tr>
	                <th class="text-center">#</th>
	                <th class="text-center">CODIGO</th>
	                <th class="text-center">DESCRIPCION</th>
	                <th class="text-center">CANTIDAD</th>
	                <th class="text-center">POR PROCESAR</th>
	                <th class="text-center">LOTE</th>
	                <th class="text-center">VENCIMIENTO</th>
          		</tr>
            </thead>

            <tbody>
				@foreach ($ingreso->detalles as $detalle)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-left">{{$detalle->id}}</td>
					<td class="text-left">{{$detalle->item_id}}</td>
					<td class="text-right">{{$detalle->cantidad}}</td>
					<td class="text-right">{{$detalle->por_procesar}}</td>
					<td class="text-center">{{$detalle->lote}}</td>
					<td class="text-center">{{$detalle->fecha_venc}}</td>
				</tr>
				@endforeach
            </tbody>

          </table>

        </div>
        <!-- /box-footer -->
    </div>
    <!-- /box -->


@endsection

@section('scripts')
    <script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
