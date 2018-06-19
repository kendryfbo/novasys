@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">

		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Guia de Despacho</h4>
		</div>
		<!-- /box-header -->

		<!-- box-body -->
		<div class="box-body">
			<form id="pdf" action="#" method="get">

			</form>
			<!-- form-horizontal -->
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarGuiaDespacho')}}">

					<div class="form-group">

            <label class="control-label col-lg-1" >Proforma:</label>
						<div class="col-lg-2">
							<input form="importar" type="number" class="form-control input-sm" name="proforma" placeholder="Numero Proforma..." value="{{$guia->proforma->numero}}" readonly required>
						</div>

						<div class="col-lg-1 col-lg-offset-8">
							<button form="pdf" class="btn btn-sm btn-default" type="submit" name="button"><i class="fa fa-print" aria-hidden="true"></i>Imprimir</button>
						</div>
					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Guia N°:</label>
						<div class="col-lg-2">
							<input type="number" class="form-control input-sm" name="numero" placeholder="Numero Guia..." value="{{$guia->numero}}" readonly required>
						</div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >Aduana:</label>
            <div class="col-lg-2">
              <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="aduana" readonly required>
                <option value="">{{$guia->aduana->descripcion}}</option>
              </select>
            </div>

            <label class="control-label col-lg-1" >Fecha:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control input-sm" name="fecha" value="{{$guia->fecha_emision}}" readonly required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >M/N:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="mn" placeholder="Moto Nave..." value="{{$guia->mn}}" readonly required>
						</div>

            <label class="control-label col-lg-1" >BK:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="booking" placeholder="Booking..." value="{{$guia->booking}}" readonly required>
						</div>

            <label class="control-label col-lg-1" >CONT:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="contenedor" placeholder="Contenedor..." value="{{$guia->contenedor}}" readonly required>
						</div>

            <label class="control-label col-lg-1" >SELLO:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="sello" placeholder="Sello..." value="{{$guia->sello}}" readonly required>
						</div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >CHOFER:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="chofer" placeholder="Nombre Chofer..." value="{{$guia->chofer}}" readonly required>
						</div>

            <label class="control-label col-lg-1" >PATENTE:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="patente" placeholder="patente del Vehiculo..." value="{{$guia->patente}}" readonly required>
						</div>

            <label class="control-label col-lg-1" >MOVIL:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="movil" placeholder="movil..." value="{{$guia->movil}}" readonly required>
						</div>

						<label class="control-label col-lg-1" >PROF:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="prof" placeholder="" value="{{$guia->prof}}" readonly required>
						</div>

          </div>

					<div class="form-group">



						<label class="control-label col-lg-1" >DUS:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="dus" placeholder="dus..." value="{{$guia->dus}}" readonly required>
						</div>

            <label class="control-label col-lg-1">K.Neto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="neto" placeholder="Peso Netos..." value="{{number_format($guia->peso_neto,2,',','.')}}" readonly required>
						</div>

						<label class="control-label col-lg-1">K.Bruto:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="bruto" placeholder="Peso Bruto..." value="{{number_format($guia->peso_bruto,2,',','.')}}" readonly required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Nota:</label>
						<div class="col-lg-11">
							<input type="text" class="form-control input-sm" name="nota" value="{{$guia->nota}}" readonly>
						</div>
					</div>

			</form>
			<!-- /form-horizontal -->
			<table class="table table-condensed table-bordered table-custom display nowrap" cellspacing="0" width="100%">

				<thead>

				  <tr>
				    <th class="text-center">#</th>
				    <th class="text-center">CODIGO</th>
				    <th class="text-center">DESCRIPCION</th>
				    <th class="text-center">CANT</th>
				  </tr>

				</thead>

				<tbody>

							@foreach ($guia->detalles as $detalle)
								<tr>
									<td class="text-center">{{$loop->iteration}}</td>
									<td class="text-center">{{$detalle->id}}</td>
									<td>{{$detalle->descripcion}}</td>
									<td class="text-center">{{$detalle->cantidad}}</td>
								</tr>
							@endforeach

				</tbody>

			</table>
			<hr>
		</div>
		<!-- /box-body -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
