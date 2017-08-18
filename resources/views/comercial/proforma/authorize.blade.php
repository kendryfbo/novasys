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

			<!-- form -->
			<form id="unauthorize" action="" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form -->

			<!-- form -->
			<form id="authorize" action="" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form -->

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="">

				{{ csrf_field() }}

        <h5>Documento</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">C. Venta:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" disabled>
								<option selected>{{$proforma->centro_venta}}</option>
            </select>
          </div>

          <label class="control-label col-lg-1">Numero:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="text" name="numero" value="{{$proforma->numero}}" readonly>
          </div>

          <label class="control-label col-lg-1">Version:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" name="version" type="number" min="0" value="{{$proforma->version}}" readonly>
          </div>

					<div class="col-lg-1 col-lg-offset-3">
						<button form="unauthorize" class="btn btn-sm btn-danger">No Autorizar<i class="fa fa-ban" aria-hidden="true"></i></button>
					</div>

					<div class="col-lg-1">
							<button form="authorize" class="btn btn-sm btn-success">Autorizar<i class="fa fa-check-circle" aria-hidden="true"></i></button>
					</div>

        </div>
        <!-- /form-group -->

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emision:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" name="emision" type="date" value="{{$proforma->fecha_emision}}">
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="clausula" disabled>
							<option>{{$proforma->clau_venta}}</option>
            </select>
          </div>

          <label class="control-label col-lg-1">Semana:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" name="semana" type="number" min="1" max="52" value="{{$proforma->semana}}">
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="cliente" disabled>
							<option>{{$proforma->cliente}}</option>
            </select>
          </div>

					<label class="control-label col-lg-2">Condicion Pago:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="formaPago" value="{{$proforma->forma_pago}}" readonly>
					</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Puerto E. :</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="puertoE" disabled>
              <option>{{$proforma->puerto_emb}}</option>
            </select>
          </div>

					<label class="control-label col-lg-2">Medio Transporte:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="transporte" disabled>
							<option>{{$proforma->transporte}}</option>
						</select>
					</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Direccion:</label>
          <div class="col-lg-5">
            <input class="form-control input-sm" type="text" name="direccion" value="{{$proforma->direccion}}" readonly>
          </div>

          <label class="control-label col-lg-1">Puerto D. :</label>
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

            @foreach ($proforma->detalles as $detalle)
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
                <th class="bg-gray text-right">FREIGHT:</th>
                <td class="text-right">{{number_format($proforma->freight,2)}}</td>
              </tr>
              <tr>
                <th class="bg-gray text-right">INSURANCE:</th>
                <td class="text-right">{{number_format($proforma->insurance,2)}}</td>
              </tr>
							<tr>
								<th colspan="2" class=""></th>
							</tr>
							<tr>
								<th class="bg-gray text-right">TOTAL F.O.B.:</th>
								<th class="text-right">{{number_format($proforma->fob,2)}}</th>
							</tr>

              <tr>
                <th class="bg-gray text-right">TOTAL:</th>
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
