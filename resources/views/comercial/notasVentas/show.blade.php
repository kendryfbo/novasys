@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Nota de Venta</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form-horizontal -->
			<div class="form-horizontal">
				<h5>Documento</h5>
				<div class="form-group">
					<label class="control-label col-sm-2" >Centro de Venta:</label>
					<div class="col-sm-4">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="centroVenta" disabled>
							<option selected value="{{$notaVenta->centroVenta->id}}">{{$notaVenta->centroVenta->descripcion}}</option>
						</select>
					</div>

					<div class="col-sm-2 pull-right">
						@if(is_null($notaVenta->aut_comer))
							<label class="btn btn-warning">Por Autorizar</label>
						@elseif ($notaVenta->aut_comer)
							<label class="btn btn-success">Autorizada</label>
						@else
							<label class="btn btn-danger">No Autorizada</label>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2" >Numero:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="numero" placeholder="Numero Nota Venta..." value="{{$notaVenta->numero}}" disabled>
					</div>
				</div>

			</div>
			<!-- /form-horizontal -->
			<hr>
			<h5>Datos</h5>
			<!-- form-inline -->
			<div class="form-inline col-sm-offset-1">

				<div class="form-group">
					<label>Fecha Emision:</label>
					<div class="input-group col-xs-2">
						<input type="date" class="form-control" name="fechaEmision" value="{{$notaVenta->fecha_emision}}" disabled>
					</div>
				</div>

				<div class="form-group">
					<label>Fechan Vencimiento:</label>
					<div class="input-group col-xs-2">
						<input type="date" class="form-control " name="fechaVenc" value="{{$notaVenta->fecha_venc}}" disabled>
					</div>
				</div>

			</div>
			<!-- /form-inline -->
			<br>
			<!-- form-inline -->
			<div class="form-inline col-sm-offset-1">

				<div class="form-group">
					<label>Cliente:</label>
					<div class="input-group" style="margin-left: 50px">
						<select class="selectpicker" data-width="500" data-live-search="true" data-style="btn-default" name="cliente" disabled>
							<option selected value="{{$notaVenta->cliente->id}}">{{$notaVenta->cliente->descripcion}}</option>
						</select>
					</div>
				</div>

				<div class="form-group" style="margin-left: 50px">
					<label>Cond. Pago:</label>
					<div class="input-group" style="margin-left: 50px">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="formaPago" disabled>
							<option selected value="{{$notaVenta->formaPago->id}}">{{$notaVenta->formaPago->descripcion}}</option>
						</select>
					</div>
				</div>

			</div>
			<!-- /form-inline -->
			<br>
			<!-- form-horizontal -->
			<div class="form-horizontal">

				<div class="form-group">
					<label class="control-label col-sm-2">Despacho:</label>
					<div class="col-sm-4">
						<select class="selectpicker" data-width="600px" data-live-search="true" data-style="btn-default" name="despacho" disabled>
							<option selected value="{{$notaVenta->despacho}}">{{$notaVenta->despacho}}</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-2">Vendedor:</label>
					<div class="col-sm-4">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="vendedor" disabled>
							<option selected value="{{$notaVenta->vendedor->id}}">{{$notaVenta->vendedor->nombre}}</option>
						</select>
					</div>
				</div>

			</div>
			<!-- /form-horizontal -->

		</div>
		<!-- /box-body -->
		<hr>
		<div class="container">
			<h5>Detalles</h5>
		</div>

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
					@foreach ($notaVenta->detalle as $item)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td>{{$item->codigo}}</td>
							<td>{{$item->descripcion}}</td>
							<td>{{$item->cantidad}}</td>
							<td>{{$item->precio}}</td>
							<td>{{$item->descuento}}</td>
							<td>{{$item->sub_total}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!-- /box-body -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form-horizontal -->
			<div class="form-horizontal">

				<div class="form-group">
					<label class="col-sm-1 control-label">Sub-Total:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="subTotal" value="{{$notaVenta->sub_total}}" disabled>
					</div>
					<label class="col-sm-1 control-label">Descuento:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="totaldescuento" value="{{$notaVenta->descuento}}" disabled>
					</div>
					<label class="col-sm-1 control-label">Neto:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="totalNeto" value="{{$notaVenta->neto}}" disabled>
					</div>
					<label class="col-sm-1 control-label">IABA:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="iaba" value="{{$notaVenta->iaba}}" disabled>
					</div>
					<label class="col-sm-1 control-label">I.V.A:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="iva" value="{{$notaVenta->iva}}" disabled>
					</div>
					<label class="col-sm-1 control-label">Total:</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="total" value="{{$notaVenta->total}}" disabled>
					</div>
				</div>

			</div>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->

		<!-- box-footer -->
		<div class="box-footer">
			<div class="form-inline">

				<div class="form-group">
					<label class="control-label">Total Peso Neto:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="peso_neto" value="{{$notaVenta->peso_neto}}" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Total Peso Bruto:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="peso_bruto" value="{{$notaVenta->peso_bruto}}" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">Volumen:</label>
					<div class="input-group">
						<input class="form-control" type="number" name="volumen" value="{{$notaVenta->volumen}}" disabled>
						<span class="input-group-addon">Kg</span>
					</div>
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
