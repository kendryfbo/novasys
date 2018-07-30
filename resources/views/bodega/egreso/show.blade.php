@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header">
			<h4 class="text-center">Egreso</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletProduccion')}}">

				{{ csrf_field() }}

				<a href="{{route('egreso')}}" class="label label-default"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Volver a Egresos</a>

                <!-- form-group -->
                <div class="form-group">

					<h5 class="col-sm-1">Orden</h5>
					<div class="col-lg-2 pull-right">
						<a class="btn btn-sm btn-default" target="_blank"  href="{{route('descargarEgresoPDF',['numero' => $egreso->numero])}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
					</div>

                </div>
                <!-- /form-group -->
                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Numero:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="numero" type="number" value="{{$egreso->numero}}" required readonly>
                    </div>

					<label class="control-label col-lg-1">Descripcion:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" name="numero" type="text" value="{{$egreso->descripcion}}" required readonly>
					</div>

					{{--
                    <label class="control-label col-lg-1">Cliente:</label>
        			<div class="col-lg-5">
						<input class="form-control input-sm" name="medida" type="text" value="{{$egreso->documento->cliente->descripcion}}" required readonly>
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
                <th class="text-center">BODEGA</th>
                <th class="text-center">UBICACION</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">CANTIDAD</th>
              </tr>

            </thead>

            <tbody>
				@foreach ($egreso->detalles as $detalle)

					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-left">{{$detalle->bodega}}</td>
						<td class="text-center">{{$detalle->posicion}}</td>
						<td class="text-left">{{$detalle->item->descripcion}}</td>
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
						<th class="text-right">{{$egreso->detalles->sum('cantidad')}}</th>
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
