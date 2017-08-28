
@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		@if ($errors->any())
			{{dd($errors)}}
		@endif

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision Factura Nacional</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="import" action="{{route('crearFactNacFromNV')}}" method="post">
				{{ csrf_field() }}
			</form>
			<!-- form -->
			<form  id="create" method="post" action="{{route('guardarFacNac')}}">

				{{ csrf_field() }}
				<!-- form-horizontal -->
				<div class="form-horizontal">

					<h5>Documento</h5>

					<div class="form-group form-group-sm">

						<label class="control-label col-sm-2" >Centro de Venta:</label>
						<div class="col-sm-3">
							<input class="form-control" type="text" name="centroVenta" value="{{$notaVenta->centroVenta->descripcion}}" readonly required>
						</div>

						<label class="col-sm-offset-1 control-label col-sm-1" >Nota Venta:</label>
						<div class="col-lg-1">
							<input form="import" class="form-control" type="number" name="numNV" value="{{$notaVenta->numero}}" placeholder="Nota Venta...">
						</div>
						<div class="col-lg-1">
              <button form="import" class="btn btn-default btn-sm" type="submit" >Importar</button>
            </div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2" >Numero:</label>
						<div class="col-lg-2">
							<input type="number" min="1" class="form-control" name="numero" placeholder="Numero de Factura..." value="" required>
						</div>
					</div>

					<h5>Datos</h5>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Fecha Emision:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control" name="fechaEmision" value="{{ Input::old('fechaEmision') ? Input::old('fechaEmision') : '' }}" required>
						</div>

						<label class="control-label col-lg-2">Fecha Vencimiento:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control " name="fechaVenc" value="{{ Input::old('fechaVenc') ? Input::old('fechaVenc') : '' }}" required>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Cliente:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control " name="cliente" value="{{$notaVenta->cliente->descripcion}}" readonly required>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Cond. Pago:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control " name="cond_pago" value="{{$notaVenta->cond_pago}}" readonly required>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Despacho:</label>
						<div class="col-lg-5">
							<input type="text" class="form-control " name="despacho" value="{{$notaVenta->despacho}}" readonly required>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Vendedor:</label>
						<div class="col-lg-3">
							<input type="text" class="form-control " name="vendedor" value="{{$notaVenta->vendedor->nombre}}" readonly required>
						</div>

					</div>

					<div class="form-group form-group-sm">

						<label class="control-label col-lg-2">Nota:</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="observacion" placeholder="Observaciones...">
						</div>

					</div>

				</div>
				<!-- /form-horizontal -->
			</form>
			<!-- /form -->
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body">

			<h5>Detalles</h5>

			<!-- form-horizontal -->
			<div class="form-horizontal">

			</div>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body" style="overflow-y: scroll;max-height:200px;border:1px solid black;">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>codigo</th>
						<th>descripcion</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Dscto</th>
						<th>total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($notaVenta->detalle as $detalle)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$detalle->codigo}}</td>
							<td>{{$detalle->descripcion}}</td>
							<td>{{$detalle->cantidad}}</td>
							<td>{{number_format($detalle->precio,0,",",".")}}</td>
							<td>{{$detalle->descuento}}</td>
							<td>{{number_format($detalle->sub_total,0,",",".")}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
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

   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
