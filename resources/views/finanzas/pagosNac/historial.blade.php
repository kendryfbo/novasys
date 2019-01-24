@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Historial de Pagos</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			@if ($errors->any())
				@foreach ($errors->all() as $error)
					@component('components.errors.validation')
            @slot('errors')
              {{$error}}
						@endslot
					@endcomponent
				@endforeach
			@endif
			<!-- form -->

    	<!-- form-group -->
        <div class="form-group">

			<label class="control-label col-lg-2">Cliente : </label>
            <div class="col-lg-2">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" id="cliente" name="cliente" v-model="clienteId" @change="getHistorialByCliente" required>
					<option value=""></option>
					@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
					@endforeach
				</select>
			</div>
        </div>
        <!-- /form-group -->
      <!-- /form -->

    </div>
    <!-- /box-body -->


	<!-- box-footer -->
	    <div class="box-footer">
	      <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
	        <thead>
	          <tr>
				<th class="text-center">#</th>
				<th class="text-center">FECHA</th>
	            <th class="text-center">N° FACT.</th>
	            <th class="text-center">DOC. PAGO</th>
	            <th class="text-center">CARGOS</th>
	            <th class="text-center">ABONOS</th>
	            <th class="text-center">SALDO</th>
	          </tr>
	        </thead>

			<tbody>
					<tr v-if="facturas <= 0">
						<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
					</tr>
					<tr v-if="facturas" v-for="(factura, key) in facturas">
						<td class="text-center">@{{key+1}}</td>
						<td class="text-center">@{{factura.numero}}</td>
						<td class="text-right">@{{factura.fecha_emision}}</td>
						<td class="text-right"></td>
						<td class="text-right">$@{{(factura.total - 2000)}}</td>
						<td class="text-right">$@{{(factura.total + 2000)}} </td>
						<td class="text-right">$@{{factura.total}}</td>
					</tr>

			</tbody>
	      </table>


	      <div class="row">

	        <div class=" col-sm-4 col-md-offset-8">
				<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

					<tr>
						<th class="bg-gray text-right">Total Cargos</th>
						<td class="input-td">
						<input class="form-control text-right" type="number" name="sub_total" readonly>
						</td>
					</tr>
					<tr>
						<th class="bg-gray text-right">Total Abonos</th>
						<td class="input-td">
						<input class="form-control text-right" type="number" name="descuento" readonly>
						</td>
					</tr>
					<tr>
						<th class="bg-gray text-right">Deuda Total</th>
						<td class="input-td">
							<input class="form-control text-right" type="number" name="neto"  readonly>
						</td>
					</tr>
				</table>
			</div>

	      </div>

	      <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
	    </div>


	    <!-- /box-footer -->
  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
	var clientes = {!!$clientes!!};
	historialFromClienteURL = "{!!route('apiObtainHistorialByClienteNacional')!!}"
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/finanzas/historialClienteNacional.js')}}"></script>
@endsection
