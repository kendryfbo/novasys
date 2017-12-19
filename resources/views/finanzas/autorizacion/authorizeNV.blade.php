@extends('layouts.masterFinanzas')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion de Nota de Venta Finanzas</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form-horizontal -->
			<div class="form-horizontal">
				<h5>Documento</h5>
				<div class="form-group form-group-sm">

					<label class="control-label col-sm-2" >Centro de Venta:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="centroVenta" placeholder="Numero Nota Venta..." value="{{$notaVenta->centroVenta->descripcion}}" readonly>
					</div>

					<div class="btn-group col-lg-offset-3">
						<button form="authorize" type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle" aria-hidden="true"></i> Autorizar</button>
						<button form="unauthorize" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> No autorizar</button>
					</div>

				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Numero:</label>
					<div class="col-lg-1">
						<input type="text" class="form-control" name="numero" placeholder="Numero Nota Venta..." value="{{$notaVenta->numero}}" readonly>
					</div>

					<label class="control-label col-lg-1">Version:</label>
					<div class="col-lg-1">
						<input type="text" class="form-control" name="version" placeholder="Numero Version..." value="{{$notaVenta->version}}" readonly>
					</div>

				</div>

				<h5>Datos</h5>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Fecha Emision:</label>
					<div class="col-lg-2">
						<input type="date" class="form-control" name="fechaEmision" value="{{$notaVenta->fecha_emision}}" readonly>
					</div>

					<label class="control-label col-lg-2">Fecha Despacho:</label>
					<div class="col-lg-2">
						<input type="date" class="form-control " name="fechaDespacho" value="{{$notaVenta->fecha_despacho}}" readonly>
					</div>

					<label class="control-label col-lg-1" >O. Compra:</label>
					<div class="col-lg-1">
						<input type="number" class="form-control" name="orden_compra" placeholder="Numero..." value="{{ $notaVenta->orden_compra }}" readonly>
					</div>

				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Cliente:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="cliente" value="{{$notaVenta->cliente->descripcion}}" readonly>
					</div>

				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Cond. Pago:</label>
					<div class="col-lg-2">
						<input type="text" class="form-control" name="formaPago" value="{{$notaVenta->cond_pago}}" readonly>
					</div>

				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Despacho:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="despacho" value="{{$notaVenta->despacho}}" readonly>
					</div>

				</div>

				<div class="form-group form-group-sm">

					<label class="control-label col-lg-2">Vendedor:</label>
					<div class="col-lg-4">
						<input type="text" class="form-control" name="vendedor"  value="{{$notaVenta->vendedor->nombre}}" readonly>
					</div>

				</div>

			</div>
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
								<td class="text-right">{{number_format($item->descuento,0,",",".")}}</td>
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
	<!-- forms -->
	<form id="authorize" action="{{route('autorizarFinanzasNV',['notaVenta' => $notaVenta->id])}}" method="post">
		{{csrf_field()}}
	</form>
	<form id="unauthorize" action="{{route('desautorizarFinanzasNV',['notaVenta' => $notaVenta->id])}}" method="post">
		{{csrf_field()}}
	</form>
	<!-- /forms -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
