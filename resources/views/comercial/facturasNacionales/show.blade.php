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

            <!-- form-horizontal -->
            <div class="form-horizontal">

                <h5>Documento</h5>

                <div class="form-group form-group-sm">

                    <label class="control-label col-sm-2" >Centro de Venta:</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" value="{{$factura->centro_venta}}" readonly>
                    </div>

                    <label class="col-sm-offset-1 control-label col-sm-1" >Nota Venta:</label>
                    <div class="col-lg-1">
                        <input class="form-control" type="text" name="numNV" value="{{$factura->numero_nv}}" readonly>
                    </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2" >Numero:</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="numero" value="{{$factura->numero}}" readonly>
                    </div>

                </div>

                <h5>Datos</h5>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Fecha Emision:</label>
                    <div class="col-lg-2">
                    <input type="date" class="form-control" name="fechaEmision" value="{{$factura->fecha_emision}}" readonly>
                    </div>

                    <label class="control-label col-lg-2">Fecha Vencimiento:</label>
                    <div class="col-lg-2">
                    <input type="date" class="form-control " name="fechaVenc" value="{{$factura->fecha_venc}}" readonly>

                </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Cliente:</label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control " value="{{$factura->cliente}}" readonly>
                    </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Cond. Pago:</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control " name="formaPago" value="{{$factura->cond_pago}}" readonly>
                    </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Despacho:</label>
                    <div class="col-lg-5">
                        <input type="text" class="form-control " name="despacho" value="{{$factura->despacho}}" readonly>
                    </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Vendedor:</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control " name="vendedor" value="{{$factura->vendedor}}" readonly>
                    </div>

                </div>

                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Nota:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="observacion" value="{{$factura->observacion}}" readonly>
                    </div>

                </div>

            </div>
            <!-- /form-horizontal -->

		</div>
		<!-- /box-body -->

		<!-- box-body -->
		<div class="box-body">

			<h5>Detalles</h5>

            <!-- Table-div -->
            <div style="overflow-y: scroll;max-height:200px;border:1px solid black;">
                <table class="table table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

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
                        @foreach ($factura->detalles as $detalle)
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
            <!-- /Table-div -->

		</div>
		<!-- /box-body -->

		<!-- box-footer -->
		<div class="box-footer">

			<div class="row">

				<div class=" col-sm-3">

					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Peso Neto:</th>
								<td class="text-right">{{$factura->peso_neto}}</td>
							</tr>
							<tr>
								<th class="bg-gray text-right">Peso Bruto:</th>
								<td class="text-right">{{$factura->peso_bruto}}</td>
							</tr>
							<tr>
								<th class="bg-gray text-right">Volumen:</th>
								<td class="text-right">{{$factura->volumen}}</td>
							</tr>
							<tr>
								<th class="bg-gray text-right">Cant. Cajas:</th>
								<td class="text-right">{{$factura->detalles->sum('cantidad')}}</td>
							</tr>


					</table>
				</div>
				<div class=" col-sm-3 col-md-offset-6">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

							<tr>
								<th class="bg-gray text-right">Sub-Total:</th>
								<td class="text-right">{{number_format($factura->sub_total,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Descuento:</th>
								<td class="text-right">{{number_format($factura->descuento,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">Neto:</th>
								<td class="text-right">{{number_format($factura->neto,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">IABA:</th>
								<td class="text-right">{{number_format($factura->iaba,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">I.V.A:</th>
								<td class="text-right">{{number_format($factura->iva,0,",",".")}}</td>
							</tr>

							<tr>
								<th class="bg-gray text-right">TOTAL:</th>
								<th class="bg-gray text-right">{{number_format($factura->total,0,",",".")}}</th>
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
