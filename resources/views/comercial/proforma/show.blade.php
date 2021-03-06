@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Proforma</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- /form pdf-->
			<form id="pdf" action="{{route('descargarProformaPDF',['numero' => $proforma->numero])}}" method="get">
			</form>
			<!-- /form pdf-->
			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="">

				{{ csrf_field() }}

		<h5>Documento</h5>
        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">C. Venta:</label>
			<div class="col-lg-2">
				<input class="form-control input-sm" type="text" name="centroVenta" value="{{$proforma->centro_venta}}" readonly>
			</div>

			<label class="control-label col-lg-1">Numero:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" type="text" name="numero" value="{{$proforma->numero}}" readonly>
			</div>

			<label class="control-label col-lg-1">Version:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" name="version" type="number" min="0" value="{{$proforma->version}}" readonly>
			</div>

			<label class="control-label col-lg-1">Autorizacion:</label>
			<div class="col-lg-2">
			  @if ($proforma->aut_comer == null)
				  <div class="has-warning">
					  <input type="text" class="form-control input-sm text-center" value="PENDIENTE" readonly>
				  </div>
			  @elseif ($proforma->aut_comer == 1)
				  <div class="has-success">
					  <input type="text" class="form-control input-sm text-center" value="AUTORIZADA" readonly>
				  </div>
			  @elseif ($proforma->aut_comer == 0)
				  <div class="has-error">
					  <input type="text" class="form-control input-sm text-center" value="NO AUTORIZADA" readonly>
				  </div>

			  @endif
			</div>

		  <div class="col-lg-2">
				  <button form="pdf" class="btn btn-sm btn-default" type="submit" name="button"><i class="fa fa-print" aria-hidden="true"></i> Descargar</button>
		  </div>
        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emisión:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" name="emision" type="date" value="{{$proforma->fecha_emision}}" readonly>
          </div>

          <label class="control-label col-lg-1">Cláusula:</label>
          <div class="col-lg-2">
			  <input class="form-control input-sm" name="clausula" type="text" value="{{$proforma->clau_venta}}" readonly>
          </div>

          <label class="control-label col-lg-1">Semana:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" name="semana" type="number" min="1" max="52" value="{{$proforma->semana}}" readonly>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-3">
			  <input class="form-control input-sm" name="cliente" type="text" value="{{$proforma->cliente->descripcion}}" readonly>
          </div>

        </div>
		<!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

		<label class="control-label col-lg-1">Dirección:</label>
		<div class="col-lg-3">
			<input class="form-control input-sm" type="text" name="formaPago" value="{{$proforma->direccion}}" readonly>
		</div>

		<label class="control-label col-lg-1">País</label>
		<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="formaPago" value="{{$proforma->cliente->pais->nombre}}" readonly>
		</div>

		<label class="control-label col-lg-2">Condición Pago:</label>
		<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="formaPago" value="{{$proforma->forma_pago}}" readonly>
		</div>

        </div>
		<!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Puerto E. :</label>
			<div class="col-lg-3">
			  <input class="form-control input-sm" type="text" name="puertoE" value="{{$proforma->puerto_emb}}" readonly>
			</div>

			<label class="control-label col-lg-2">Medio Transporte:</label>
			<div class="col-lg-3">
				<input class="form-control input-sm" type="text" name="transporte" value="{{$proforma->transporte}}" readonly>
			</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Dir. Desp.:</label>
          <div class="col-lg-3">
            <input class="form-control input-sm" type="text" name="direccion" value="{{$proforma->despacho}}" readonly>
          </div>

          <label class="control-label col-lg-2">Puerto D. :</label>
          <div class="col-lg-4">
            <input class="form-control input-sm" type="text" name="puertoD" value="{{$proforma->puerto_dest}}" readonly>
          </div>

        </div>
        <!-- /form-group -->

				<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Nota:</label>
          <div class="col-lg-10">
            <input class="form-control input-sm" type="text" name="nota" value="{{$proforma->nota}}" readonly>
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

  <!--<div style="overflow-y: scroll;max-height:200px;border:1px solid black;">-->
      <div>
        <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

          <thead>

            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">Cant</th>
              <th class="text-center">Precio</th>
              <th class="text-center">%Desc</th>
              <th class="text-center">Total</th>
            </tr>

          </thead>

          <tbody>

            @foreach ($proforma->detalles as $detalle)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-center">{{$detalle->codigo}}</td>
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
                <td class="text-right">{{$proforma->peso_neto}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Peso Bruto:</th>
                <td class="text-right">{{$proforma->peso_bruto}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Volumen:</th>
                <td class="text-right">{{$proforma->volumen}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">Cant. Cajas:</th>
                <td class="text-right">{{$proforma->detalles->sum('cantidad')}}</td>
              </tr>


          </table>
        </div>
        <div class=" col-sm-3 col-md-offset-6">
			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

				<tr>
					<th class="bg-gray text-right">TOTAL F.O.B. US$</th>
					<th class="text-right">{{number_format($proforma->fob,2)}}</th>
				</tr>
				<tr>
					<th class="bg-gray text-right">FREIGHT US$</th>
					<td class="text-right">{{number_format($proforma->freight,2)}}</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">INSURANCE US$</th>
					<td class="text-right">{{number_format($proforma->insurance,2)}}</td>
				</tr>
				<tr>
					<th colspan="2" class=""></th>
				</tr>

				<tr>
				<th class="bg-gray text-right">TOTAL US$</th>
				<th class="bg-gray text-right">{{number_format($proforma->total,2)}}</th>
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
