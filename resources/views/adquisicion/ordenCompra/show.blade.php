@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Visualizacion de Orden de Compra</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form complete-->
			<form id="complete" action="{{route('ordenCompraCompleta',['ordenCompra' => $ordenCompra->id])}}" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form complete-->
			<!-- form incomplete-->
			<form id="incomplete" action="{{route('ordenCompraIncompleta',['ordenCompra' => $ordenCompra->id])}}" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form incomplete-->
			<!-- form sendEmail-->
			<form id="sendEmail" action="{{route('enviarEmailOrdenCompra',['numero' => $ordenCompra->numero])}}" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form sendEmail-->
			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarOrdenCompra')}}">

				{{ csrf_field() }}

        <h5>Documento</h5>

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Numero:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" type="text" name="numero" value="{{$ordenCompra->numero}}" readonly>
			</div>
			<label class="control-label col-lg-1">Status:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" type="text" name="numero" value="{{$ordenCompra->status->descripcion}}" readonly>
			</div>

			<div class="col-lg-2">
				<div class="btn-group" role="group" aria-label="...">
					<button form="complete" type="submit" class="btn btn-success btn-sm">Completar</button>
					<button form="incomplete" type="submit" class="btn btn-warning btn-sm">Pendiente</button>
				</div>
			</div>

			<label class="control-label col-lg-1">Autorizacion:</label>
			<div class="col-lg-2">
				@if ($ordenCompra->aut_contab == null)
					<div class="has-warning">
						<input type="text" class="form-control input-sm text-center" value="PENDIENTE" readonly>
					</div>
				@elseif ($ordenCompra->aut_contab == 1)
					<div class="has-success">
						<input type="text" class="form-control input-sm text-center" value="AUTORIZADA" readonly>
					</div>
				@elseif ($ordenCompra->aut_contab == 0)
					<div class="has-error">
						<input type="text" class="form-control input-sm text-center" value="NO AUTORIZADA" readonly>
					</div>

				@endif
			</div>
			@if ($ordenCompra->aut_contab)
				<div class="col-lg-1 col-lg-offset-1">
					<button form="download" class="btn btn-default btn-sm" type="submit" name="button"><i class="fa fa-download" aria-hidden="true"></i> Descargar</button>
				</div>
			@endif

        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Proveedor:</label>
            <div class="col-lg-4">
				<input class="form-control input-sm" type="text" name="prov_id" value="{{$ordenCompra->proveedor->descripcion}}" readonly>
            </div>

			<label class="control-label col-lg-1">Emision:</label>
			<div class="col-lg-2">
				<input class="form-control input-sm" name="fecha_emision" type="date" value="{{$ordenCompra->fecha_emision}}" readonly>
			</div>

			<label class="control-label col-lg-1">Area:</label>
            <div class="col-lg-2">
				<input class="form-control input-sm" name="area_id" type="text" value="{{$ordenCompra->area->descripcion}}" readonly>
            </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Cond. Pago:</label>
			<div class="col-lg-4">
				<input class="form-control input-sm" type="text" name="forma_pago" value="{{$ordenCompra->forma_pago}}" readonly>
			</div>

			<label class="control-label col-lg-1">Moneda:</label>
            <div class="col-lg-2">
				<input class="form-control input-sm" type="text" name="forma_pago" value="{{$ordenCompra->moneda}}" readonly>
            </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Contacto:</label>
			<div class="col-lg-2">
				<input class="form-control input-sm" type="text" name="contacto" value="{{$ordenCompra->contacto}}" readonly>
			</div>
			<label class="control-label col-lg-1">Email:</label>
			<div class="col-lg-4">
				<input form="sendEmail" class="form-control input-sm" type="text" name="mail" value="{{$ordenCompra->proveedor->email}}">
			</div>

			<div class="col-lg-1">
				<button form="sendEmail" type="submit" class="btn btn-default btn-sm">Email</button>
			</div>

			<div class="col-lg-4">
				<div class="radio-inline">
					<label>
						<input type="radio" name="tipo" value="{{$ordenCompra->tipo_id}}" checked readonly>
						{{$ordenCompra->tipo->descripcion}}
					</label>
				</div>
			</div>

        </div>
        <!-- /form-group -->

		<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Nota:</label>
          <div class="col-lg-10">
            <input class="form-control input-sm" type="text" name="nota" value="{{$ordenCompra->nota}}" readonly>
          </div>

        </div>
        <!-- /form-group -->

        <h5>Detalle</h5>
        <!-- form-group -->
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
			<th class="text-center">U.MED</th>
            <th class="text-center">CANT</th>
            <th class="text-center">PRECIO</th>
            <th class="text-center">TOTAL</th>
          </tr>

        </thead>

        <tbody>
		@foreach ($ordenCompra->detalles as $detalle)

			<tr>
				<td class="text-center">{{$loop->iteration}}</td>
				<td class="text-center">{{$detalle->codigo}}</td>
				<td>{{$detalle->descripcion}}</td>
				<td class="text-right">{{$detalle->unidad}}</td>
				<td class="text-right">{{$detalle->cantidad}}</td>
				<td class="text-right">{{$detalle->precio}}</td>
				<td class="text-right">{{$detalle->sub_total}}</td>
			</tr>

		@endforeach
        </tbody>

      </table>

      <div class="row">

        <div class=" col-sm-4 col-md-offset-8">
			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

				<tr>
					<th class="bg-gray text-right">SUB-TOTAL</th>
					<td class="input-td">
					<input class="form-control text-right" type="text" name="sub_total" value="{{number_format($ordenCompra->sub_total,2)}}" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">% DESC.:</th>
					<td class="input-td">
						<input form="create" class="form-control text-right" type="text" name="porc_desc" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">DESCUENTO:</th>
					<td class="input-td">
						<input class="form-control text-right" type="text" name="descuento" value="{{number_format($ordenCompra->descuento,2)}}" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">NETO:</th>
					<td class="input-td">
						<input class="form-control text-right" type="text" name="neto" value="{{number_format($ordenCompra->neto,2)}}" readonly>
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">IMPUESTO:</th>
					<td class="input-td">
						<input form="create" class="form-control text-right" type="text" name="impuesto" value="{{number_format($ordenCompra->impuesto,2)}}" readonly>
					</td>
				</tr>
				<tr>
					<th colspan="2" class=""></th>
				</tr>

				<tr>
					<th class="bg-gray text-right">TOTAL:</th>
					<td class="input-td">
						<input class="form-control text-right" type="text" name="total" value="{{number_format($ordenCompra->total,2)}}" readonly>
					</td>
				</tr>

			</table>
        </div>

      </div>
    </div>
    <!-- /box-footer -->
	<form id="download" method="get" action="{{route('descargarOrdenCompraPDF',['numero' => $ordenCompra->numero])}}">
		{{ csrf_field() }}
	</form>

  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
