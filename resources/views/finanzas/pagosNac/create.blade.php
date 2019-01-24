@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Pago de Facturas Nacionales</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" onsubmit="return confirm('¿Está seguro de querer Ingresar el Pago?');" action="{{route('guardaPagoNacional')}}">
				{{ csrf_field() }}
				<!-- form-group -->
				<a class="btn btn-info" href="{{route('pagosNacional')}}">Volver</a>
        <div class="form-group">

					<label class="control-label col-lg-1">Cliente : </label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" value="{{$cliente->descripcion}}" readonly>
						<input class="form-control input-sm" type="hidden" name="clienteID" value="{{$cliente->id}}" readonly>
					</div>
					<label class="control-label col-lg-1">Fecha Pago : </label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_hoy" value="" required>
					</div>

					<label class="control-label col-lg-1">Tipo Docu. </label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipo_documento">
							<option value="CHEQUE">CHEQUE</option>
							<option value="TRANSF. ELECTRÓNICA">TRANSF. ELECTRÓNICA</option>
						</select>
					</div>

					<label class="control-label col-lg-1">Banco : </label>
					<div class="col-lg-2">
						
					</div>
				</div>
				<!-- /form-group -->
        <!-- form-group -->
        <div class="form-group">

					<label class="control-label col-lg-1">Monto a Pagar : </label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="number" name="montoDepo" v-model="montoDepo">
					</div>

					<label class="control-label col-lg-1">Docu. Pago : </label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="numero_documento" required>
					</div>

					<label class="control-label col-lg-1">Anticip. Usado : </label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="monto_abonado" v-model="montoAnticipo" value="0" readonly>
					</div>

					<label class="control-label col-lg-1">N/C Usado : </label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="monto_notaCredito" v-model="montoNC" value="0" readonly>
					</div>

					<label class="control-label col-lg-1">Crédito : </label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="credito" value="{{$cliente->credito}}" readonly>
					</div>
        </div>
        <!-- /form-group -->

				<!-- Items -->
				<select style="display: none;"  name="facturas[]" multiple>
					<option v-for="factura in facturas" selected>
						@{{factura}}
					</option>
				</select>
				<!-- /items -->

			</form>
      <!-- /form -->
    </div>
    <!-- /box-body -->

		<!-- box-footer -->
    <div class="box-footer">
	  <h5>Facturas</h5>
	  <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
						<th class="text-center">#</th>
						<th class="text-center">N° FACT.</th>
            			<th class="text-center">FECHA</th>
            			<th class="text-center">SALDO</th>
            			<th class="text-center" width="200px">MONTO A PAGAR</th>
						<th class="text-center">ACCION</th>


		  		</tr>
        </thead>
				<tbody>
					<tr v-if="facturas <= 0">
						<td colspan="9" class="text-center" >Tabla Sin Facturas...</td>
					</tr>
					<tr v-if="facturas" v-for="(factura, key) in facturas">
					    <td class="text-center">@{{key+1}}</td>
					    <td class="text-center">@{{factura.numero}}</td>
					    <td class="text-right">@{{factura.fecha_emision}}</td>
					    <td class="text-right">CLP @{{formatPrice(factura.deuda - ~~factura.pago)}}</td>



					    <td class="text-right">
								<input class="form-control" :id="factura.id" type="number" @focus="cargarPago(factura.id,$event)">
							</td>
							<td class="text-center">
								<button type="button" name="button" @click="registrarPago(factura.id)">Pagar</button>
							</td>
					</tr>
				</tbody>
      </table>


	  <h5>Anticipos</h5>
	  <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
		  <thead>
			  <tr>
				  <th class="text-center">#</th>
				  <th class="text-center">O.D.</th>
				  <th class="text-center">FECHA</th>
				  <th class="text-center">MONTO</th>
				  <th class="text-center">RESTANTE</th>
				  <th class="text-center" width="200px">MONTO A UTILIZAR</th>
				  <th class="text-center">ACCION</th>
			  </tr>
		  </thead>
				<tbody>
					<tr v-if="abonos <= 0">
						<td colspan="9" class="text-center" >Tabla Sin Anticipos...</td>
					</tr>
					<tr v-if="abonos" v-for="(abono, key) in abonos">
						<td class="text-center">@{{key+1}}</td>
						<td class="text-center">@{{abono.orden_despacho}}</td>
						<td class="text-right">@{{abono.fecha_abono}}</td>
						<td class="text-right">CLP @{{numberFormat(abono.restante)}}</td>
						<td class="text-right">CLP @{{numberFormat(abono.restante - ~~abono.anticipo)}}</td>
						<td class="text-right">
								<input class="form-control" :id="abono.id" type="number" @focus="cargarAbono(abono.id,$event)">
							</td>
							<td class="text-center">
								<button type="button" name="button" @click="add(utilizarAbono(abono.id))">Usar</button>
							</td>
					</tr>
				</tbody>
	  </table>


	  <h5>Notas de Crédito</h5>
	  <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
	    <thead>
	  	<tr>
	  				  <th class="text-center">#</th>
	  				  <th class="text-center">N° N/C.</th>
	  				  <th class="text-center">FECHA</th>
					  <th class="text-center">NUM. FACTURA</th>
	  				  <th class="text-center">MONTO</th>
	  				  <th class="text-center">RESTANTE</th>
	  				  <th class="text-center" width="200px">MONTO A UTILIZAR</th>
	  				  <th class="text-center">ACCION</th>


	  		  </tr>
	    </thead>
	  		  <tbody>
	  			  <tr v-if="notasCredito <= 0">
	  				  <td colspan="9" class="text-center" >Tabla Sin Notas de Crédito...</td>
	  			  </tr>
	  			  <tr v-if="notasCredito" v-for="(notaCredito, key) in notasCredito">
	  				  <td class="text-center">@{{key+1}}</td>
	  				  <td class="text-center">@{{notaCredito.numero}}</td>
	  				  <td class="text-right">@{{notaCredito.fecha}}</td>
					  <td class="text-right">@{{notaCredito.num_fact}}</td>
	  				  <td class="text-right">CLP @{{numberFormat(notaCredito.restante)}}</td>
	  				  <td class="text-right">CLP @{{numberFormat(notaCredito.restante - ~~notaCredito.notaCredito)}}</td>
	  				  <td class="text-right">
						  <input class="form-control" :id="notaCredito.id" type="number" @focus="cargarNotaCredito(notaCredito.id,$event)">
	  					  </td>
	  					  <td class="text-center">
							 <button type="button" name="button" @click="utilizarNotaCredito(notaCredito.id)">Usar</button>
	  					  </td>
	  			  </tr>
	  		  </tbody>
	  </table>

    	<div class="row">
        <div class=" col-sm-4 col-md-offset-8">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

						<tr>
							<th class="bg-gray text-right">Deuda Total</th>
							<td class="input-td">
							<input class="form-control text-right" type="number" :value="montoFactura" readonly >
							</td>
						</tr>
						<tr>
							<th class="bg-gray text-right">Saldo Total Anticipos</th>
							<td class="input-td">
							<input class="form-control text-right" type="number" :value="saldoTotalAbono" readonly>
							</td>
						</tr>
						<tr>
							<th class="bg-gray text-right">Saldo Total Notas Crédito</th>
							<td class="input-td">
							<input class="form-control text-right" type="number" :value="saldoTotalNC" readonly>
							</td>
						</tr>
					</table>
				</div>
      </div>
      <button form="create" class="btn btn-default pull-right" type="submit">Ingresar</button>
    </div>
    <!-- /box-footer -->
  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var clientes = [];
	var facturas = {!!$facturas!!};
	var abonos = {!!$abonos!!};
	var notasCredito = {!!$notasCredito!!};
	var saldoTotalAbono = {!!$saldoTotalAbono!!}
	var saldoTotalNC = {!!$saldoTotalNC!!}
	facturaFromClienteURL = "{!!route('apiObtainFacturasByClienteNacional')!!}";
	abonoFromClienteURL = "{!!route('apiObtainAbonosByClienteNacional')!!}"
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/finanzas/pagosNacional.js')}}"></script>
@endsection
