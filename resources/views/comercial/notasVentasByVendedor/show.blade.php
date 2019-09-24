@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Nota de Venta</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- /form pdf-->
			<form id="pdf" action="{{route('descargarNotaVentaPDF',['numero' => $notaVenta->numero])}}" method="get">
			</form>
			<!-- /form pdf-->
			<!-- form-horizontal -->
			<form class="form-horizontal">
				<h5>Documento</h5>

				<div class="form-group">

					<label class="control-label col-sm-1" >C.Venta:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control input-sm" name="centroVenta" placeholder="Numero Nota Venta..." value="{{$notaVenta->centroVenta->descripcion}}" readonly>
					</div>

					<label class="control-label col-lg-1">Numero:</label>
					<div class="col-lg-1">
						<input type="text" class="form-control input-sm" name="numero" placeholder="Numero Nota Venta..." value="{{$notaVenta->numero}}" readonly>
					</div>

					<label class="control-label col-lg-1">Version:</label>
					<div class="col-lg-1">
						<input type="text" class="form-control input-sm" name="version" placeholder="Numero Version..." value="{{$notaVenta->version}}" readonly>
					</div>

					<label class="control-label col-lg-1">Autorizacion:</label>
					<div class="col-lg-2">
					  @if ($notaVenta->aut_comer == null)
						  <div class="has-warning">
							  <input type="text" class="form-control input-sm text-center" value="PENDIENTE" readonly>
						  </div>
					  @elseif ($notaVenta->aut_comer == 1)
						  <div class="has-success">
							  <input type="text" class="form-control input-sm text-center" value="AUTORIZADA" readonly>
						  </div>
					  @elseif ($notaVenta->aut_comer == 0)
						  <div class="has-error">
							  <input type="text" class="form-control input-sm text-center" value="NO AUTORIZADA" readonly>
						  </div>

					  @endif
					</div>

					<div class="col-lg-2">
		  			  @if ($notaVenta->aut_comer)
		  				  <button form="pdf" class="btn btn-sm btn-default" type="submit" name="button"><i class="fa fa-print" aria-hidden="true"></i> Descargar</button>
		  			  @endif
		  		  </div>

				</div>

				<h5>Datos</h5>

				<div class="form-group">

					<label class="control-label col-lg-1">F. Emision:</label>
					<div class="col-lg-2">
						<input type="date" class="form-control input-sm text-center" name="fechaEmision" value="{{$notaVenta->fecha_emision}}" readonly>
					</div>

					<label class="control-label col-lg-1">F. Despacho:</label>
					<div class="col-lg-2">
						<input type="date" class="form-control input-sm text-center" name="fechaDespacho" value="{{$notaVenta->fecha_despacho}}" readonly>
					</div>

					<label class="control-label col-lg-1" >O. Compra:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control input-sm text-center" name="orden_compra" placeholder="Numero..." value="{{ $notaVenta->orden_compra }}" readonly>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control input-sm" name="cliente" value="{{$notaVenta->cliente->descripcion}}" readonly>
					</div>

					<label class="control-label col-lg-1">Cond. Pago:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="formaPago" value="{{$notaVenta->cond_pago}}" readonly>
					</div>

				</div>



				<div class="form-group">

					<label class="control-label col-lg-1">Despacho:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control input-sm" name="despacho" value="{{$notaVenta->despacho}}" readonly>
					</div>

					<label class="control-label col-lg-1">Vendedor:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control input-sm" name="vendedor"  value="{{$notaVenta->vendedor->nombre}}" readonly>
					</div>

				</div>

			</form>
			<!-- /form-horizontal -->
			<h5>Detalles</h5>

			<div style="overflow-y: scroll;max-height:200px;border:1px solid black;">

				<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

					<thead>

						<tr>
							<th class="text-center">#</th>
							<th class="text-center">codigo</th>
							<th class="text-center">descripcion</th>
							<th class="text-center">Cantidad</th>
							<th class="text-center">Precio</th>
							<th class="text-center">Dscto</th>
							<th class="text-center">total</th>
						</tr>

					</thead>

					<tbody>
						@foreach ($notaVenta->detalle as $item)
							<tr>
								<th class="text-center">{{$loop->iteration}}</th>
								<td class="text-center">{{$item->codigo}}</td>
								<td>{{$item->descripcion}}</td>
								<td class="text-right">{{$item->cantidad}}</td>
								<td class="text-right">{{number_format($item->precio,0,",",".")}}</td>
								<td class="text-right">{{$item->descuento}}</td>
								<td class="text-right">{{number_format($item->sub_total,0,",",".")}}</td>
							</tr>
						@endforeach
					</tbody>

				</table>

			</div>

		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">

			<div class="row">

				<div class=" col-sm-3">

					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Peso Neto:</th>
								<td class="text-right">{{$notaVenta->peso_neto}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Peso Bruto:</th>
								<td class="text-right">{{$notaVenta->peso_bruto}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Volumen:</th>
								<td class="text-right">{{$notaVenta->volumen}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Cant. Cajas:</th>
								<td class="text-right">{{$notaVenta->detalle->sum('cantidad')}}</td>
							</tr>

					</table>
				</div>
				<div class=" col-sm-3 col-md-offset-6">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Sub-Total:</th>
								<td class="text-right">{{number_format($notaVenta->sub_total,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Descuento:</th>
								<td class="text-right">{{number_format($notaVenta->descuento,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Neto:</th>
								<td class="text-right">{{number_format($notaVenta->neto,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">IABA:</th>
								<td class="text-right">{{number_format($notaVenta->iaba,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">I.V.A:</th>
								<td class="text-right">{{number_format($notaVenta->iva,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">TOTAL:</th>
								<th class="bg-gray text-right">{{number_format($notaVenta->total,0,",",".")}}</th>
							</tr>

					</table>
				</div>

			</div>
 	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
