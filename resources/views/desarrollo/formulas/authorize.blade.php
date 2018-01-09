@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Autorizacion de Formula</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form unauthorize-->
			<form id="authorize" action="{{route('autorizarFormula',['proforma' => $formula->id])}}" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form unauthorize-->
			<!-- form authorize-->
			<form id="unauthorize" action="{{route('desautorizarFormula',['proforma' => $formula->id])}}" method="post">
				{{csrf_field()}}
			</form>
			<!-- /form authorize-->

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="">

				{{ csrf_field() }}

        <h5>Datos</h5>

        <!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-1">Producto:</label>
			<div class="col-lg-3">
				<input class="form-control input-sm" type="text" name="descripcion" value="{{$formula->producto->descripcion}}" readonly>
			</div>

			<label class="control-label col-lg-1">Batch:</label>
			<div class="col-lg-1">
				<input class="form-control input-sm" type="number" name="batch" value="{{$formula->cant_batch}}" readonly>
			</div>

			<div class="btn-group col-lg-offset-4">
				<!-- Button trigger modal auth -->
				<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#authModal"><i class="fa fa-check-circle" aria-hidden="true"></i> Autorizar</button>
				<!-- Button trigger modal unauth -->
				<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#unauthModal"><i class="fa fa-ban" aria-hidden="true"></i> No autorizar</button>
			</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Gen. Por:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" name="generada_por" type="text" value="{{$formula->generada_por}}" readonly>
          </div>

          <label class="control-label col-lg-2">Fecha Creacion:</label>
          <div class="col-lg-2">
			<input class="form-control input-sm" name="fecha_gen" type="date"  value="{{$formula->fecha_gen}}" readonly>
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

      <div style="overflow-y: scroll;border:1px solid black;">

        <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

          <thead>

            <tr>
              <th class="text-center">#</th>
              <th class="text-center">id</th>
              <th class="text-center">DESCRIPCION</th>
			  <th class="text-center">Nivel</th>
              <th class="text-center">CantXuni</th>
              <th class="text-center">CantXcaja</th>
              <th class="text-center">cantXbatch</th>
            </tr>

          </thead>

          <tbody>

            @foreach ($formula->detalle as $detalle)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-center">{{$detalle->id}}</td>
                <td class="text-left">{{$detalle->descripcion}}</td>
				<td class="text-left">{{$detalle->nivel->descripcion}}</td>
                <td class="text-right">{{rtrim(sprintf('%.8F', $detalle->cantxuni), '0')}}</td>
                <td class="text-right">{{rtrim(sprintf('%.5F', $detalle->cantxcaja), '0')}}</td>
                <td class="text-right">{{rtrim(sprintf('%.3F', $detalle->cantxbatch), '0')}}</td>
              </tr>
            @endforeach

          </tbody>

        </table>

      </div>
      <br>
	  {{--
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
	  --}}
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->

<!-- Modal Auth-->
<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Confirme Autorizacion de Formula de producto <strong>{{$formula->producto->descripcion}}</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
		<button form="authorize" type="submit" class="btn btn-success btn-sm">Autorizar</button>
      </div>
    </div>
  </div>
</div>
<!-- /Modal Auth -->

<!-- Modal Unauth-->
<div class="modal fade" id="unauthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
          Confirme No-Autorizacion de Formula de producto <strong>{{$formula->producto->descripcion}}</strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
		  <button form="unauthorize" type="submit" class="btn btn-danger btn-sm">No autorizar</button>

        </div>
    </div>
  </div>
</div>
<!-- /Modal Unauth -->

@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
