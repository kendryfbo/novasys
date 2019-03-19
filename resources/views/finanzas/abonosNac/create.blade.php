@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingresar Anticipo a Cliente Nacional</h4>
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
			<form class="form-horizontal"  id="create" action="{{route('guardaAbonoNacional')}}" method="post">
				{{ csrf_field() }}

    	<!-- form-group -->
        <div class="form-group">

			<br>

			<label class="control-label col-lg-1">Cliente : </label>
            <div class="col-lg-2">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente" required>
					<option value=""></option>
					@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
					@endforeach
				</select>
			</div>


				<label class="control-label col-lg-1">Nota de Venta : </label>
				<div class="col-lg-1">
			   		<input class="form-control input-sm" type="text" name="orden_despacho" placeholder="N.V.">
			   	</div>

			<label class="control-label col-lg-1">Forma Ant. : </label>
			<div class="col-lg-2">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="forma_pago" required>
					<option value=""></option>
					@foreach ($formasPago as $formaPago)
						<option value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
					@endforeach
				</select>
			</div>

			<label class="control-label col-lg-1">Fecha Anticipo : </label>
			<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="fecha_abono" value="{{$fecha_hoy->format('Y-m-d')}}" readonly>
			</div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

		<label class="control-label col-lg-1">Banco : </label>
		<div class="col-lg-2">

			<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="banco">
				<option value=""></option>
				@foreach ($bancos as $banco)
					<option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
				@endforeach
			</select>

		</div>

		<label class="control-label col-lg-1">Monto Ant.$ : </label>
		<div class="col-lg-1">
			<input class="form-control input-sm" type="number" name="monto"  value="" required>
		</div>

		<label class="control-label col-lg-1">N° de Documento</label>
		<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="docu_abono" placeholder="Folio de Transferencia o N° de Cheque" required>
		</div>

		<label class="control-label col-lg-1">Fecha Cobro : </label>
		<div class="col-lg-2">
			<input class="form-control input-sm" type="date" name="fecha_cobro" placeholder="Cheques" value="">
		</div>


		</div>

      <!-- /form -->
	  <button form="create" class="btn btn-default pull-right" type="submit">Registrar</button>
    </div>
    <!-- /box-body -->


	<!-- box-footer -->

	    </div>
	</form>

	    <!-- /box-footer -->
  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
