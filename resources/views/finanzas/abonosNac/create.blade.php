@extends('layouts.masterFinanzas')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingresar Abono a Cliente Nacional</h4>
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

			<label class="control-label col-lg-2">Cliente : </label>
            <div class="col-lg-2">
				<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente" required>
					<option value=""></option>
					@foreach ($clientes as $cliente)
						<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>
					@endforeach
				</select>
			</div>

			<label class="control-label col-lg-2">Fecha Depósito : </label>
			<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="fecha_abono" value="{{$fecha_hoy}}" readonly>
			</div>
        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

		  <label class="control-label col-lg-2">Orden de Despacho : </label>
		  <div class="col-lg-2">
        	<input class="form-control input-sm" type="text" name="orden_despacho" value="">
          </div>

		  <label class="control-label col-lg-2">Monto Abono $ : </label>
		  <div class="col-lg-2">
        	<input class="form-control input-sm" type="number" name="monto"  value="">
          </div>
        </div>
        <!-- /form-group -->

		<div class="form-group">

			<label class="control-label col-lg-2">Documento de Pago </label>
			<div class="col-lg-2">
			<input class="form-control input-sm" type="text" name="docu_abono" placeholder="SWIFT"  value="">
			</div>
		</div>

      <!-- /form -->
	  <button form="create" class="btn btn-default pull-right" type="submit">Abonar</button>
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
