@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision Factura Internacional</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="edit" method="post" action="{{route('actualizarFacturaIntl',['facturaIntl' => $factura->id])}}">
				{{ csrf_field() }}
        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Factura N°:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="numero"  min="0" name="numero" value="{{$factura->numero}}" autofocus required>
          </div>

					<label class="control-label col-lg-1 col-lg-offset-6">Proforma:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" name="proforma" value="{{$factura->numero}}" readonly>
					</div>

        </div>
        <!-- /form-group -->

				<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emision:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" type="date" name="emision" value="{{$factura->fecha_emision}}" required>
          </div>
		{{--
          <label class="control-label col-lg-1">Vencimiento:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" type="date" name="vencimiento" required>
          </div>
	  	--}}
        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">C. Venta:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" disabled required>
              <option value="{{$factura->cv_id}}">{{$factura->centro_venta}}</option>

            </select>
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="clausula" disabled required>
              <option value="{{$factura->clau_venta}}">{{$factura->clau_venta}}</option>
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="cliente" required disabled>
							<option value="{{$factura->cliente_id}}">{{$factura->clienteIntl->descripcion}}</option>
            </select>
          </div>

					<label class="control-label col-lg-2">Condicion Pago:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="formaPago" required disabled>
							<option value="{{$factura->forma_pago}}">{{$factura->forma_pago}}</option>
						</select>
						<input type="hidden" name="diasFormaPago" value="{{$factura->clienteIntl->formaPago->dias}}"  required>
					</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Puerto E. :</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="puertoE" required disabled>
              <option value="{{$factura->puerto_emb}}">{{$factura->puerto_emb}}</option>
            </select>
          </div>

					<label class="control-label col-lg-2">Medio Transporte:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="transporte" required disabled>
							<option value="{{$factura->transporte}}">{{$factura->transporte}}</option>
						</select>
					</div>


        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Direccion:</label>
          <div class="col-lg-5">
            <input class="form-control input-sm"type="text" name="direccion" value="{{$factura->direccion}}" required readonly>
          </div>

          <label class="control-label col-lg-1">Puerto D. :</label>
          <div class="col-lg-4">
            <input class="form-control input-sm" type="text" name="direccion" value="{{$factura->puerto_dest}}" required readonly>
          </div>

        </div>
        <!-- /form-group -->

				<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Nota:</label>
          <div class="col-lg-10">
            <input class="form-control input-sm" type="text" name="nota" value="{{$factura->nota}}">
          </div>

        </div>
        <!-- /form-group -->

      </form>
      <!-- /form -->

    </div>
    <!-- /box-body -->

    <!-- box-footer -->
    <div class="box-footer">

			<h5>Detalle</h5>

			<div style="overflow-y: scroll;max-height:200px;border:1px solid black;">

		    <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

		      <thead>

		        <tr>
		          <th class="text-center">#</th>
		          <th class="text-center">CODIGO</th>
		          <th class="text-center">DESCRIPCION</th>
		          <th class="text-center">CANT</th>
		          <th class="text-center">PRECIO</th>
		          <th class="text-center">DESC</th>
		          <th class="text-center">TOTAL</th>
		        </tr>

		      </thead>

		      <tbody>

						@foreach ($factura->detalles as $detalle)
							<tr>
								<td class="text-center">{{$loop->iteration}}</td>
								<td class="text-center">{{$detalle->prod_id}}</td>
								<td>{{$detalle->descripcion}}</td>
								<td class="text-right">{{$detalle->cantidad}}</td>
								<td class="text-right">{{number_format($detalle->precio,2)}}</td>
								<td class="text-right">{{$detalle->descuento}}</td>
								<td class="text-right">{{number_format($detalle->sub_total,2)}}</td>
							</tr>
						@endforeach

		      </tbody>

		    </table>

			</div>

			<br>

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
							<th class="bg-gray text-right">TOTAL F.O.B.:</th>
							<th class="text-right">{{number_format($factura->fob,2)}}</th>
						</tr>
						<tr>
							<th class="bg-gray text-right">FREIGHT:</th>
							<td class="text-right">{{number_format($factura->freight,2)}}</td>
						</tr>
						<tr>
							<th class="bg-gray text-right">INSURANCE:</th>
							<td class="text-right">{{number_format($factura->insurance,2)}}</td>
						</tr>
						<tr>
							<th colspan="2" class=""></th>
						</tr>
						<tr>
							<th class="bg-gray text-right">TOTAL:</th>
							<th class="bg-gray text-right">{{number_format($factura->total,2)}}</th>
						</tr>

	        </table>
	      </div>

	    </div>

    	<button form="edit" class="btn btn-default pull-right" type="submit">Modificar</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
@endsection
