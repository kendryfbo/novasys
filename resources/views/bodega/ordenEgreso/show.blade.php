@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Orden Egreso</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletProduccion')}}">

				{{ csrf_field() }}

                <h5>Orden</h5>

                <!-- form-group -->
                <div class="form-group">


					<div class="col-lg-2 pull-right">
						<a class="btn btn-sm btn-default"  href="{{route('descargarOrdenEgresoPDF',['numero' => $ordenEgreso->numero])}}"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
					</div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Numero:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="numero" type="number" value="{{$ordenEgreso->numero}}" required readonly>
                    </div>

                    <label class="control-label col-lg-1">Cliente:</label>
        			<div class="col-lg-5">
						<input class="form-control input-sm" name="medida" type="text" value="{{$ordenEgreso->documento->cliente}}" required readonly>
        			</div>


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
				@foreach ($ordenEgreso->detalles as $detalle)

					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-left">{{$detalle->bodega}}</td>
						<td class="text-left">{{$detalle->posicion}}</td>
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
						<th class="text-right">{{$ordenEgreso->detalles->sum('cantidad')}}</th>
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
