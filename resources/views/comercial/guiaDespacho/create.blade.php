@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Generar Guia de Despacho</h4>

			@if ($errors->any())

				@foreach ($errors->all() as $error)

					@component('components.errors.validation')
						@slot('errors')
							{{$error}}
						@endslot
					@endcomponent

				@endforeach

			@endif

		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="importar" action="{{route('crearGuiaDespacho')}}" method="get">
			</form>
			<!-- form-horizontal -->
			<form  id="create" class="form-horizontal" method="post" action="{{route('guardarGuiaDespacho')}}">

				{{ csrf_field() }}

					<div class="form-group">

            <label class="control-label col-lg-1" >Proforma:</label>
						<div class="col-lg-2">
							<input form="importar" type="number" class="form-control input-sm" name="proforma" placeholder="Numero Proforma..." value="{{$proforma ? $proforma->numero:''}}" required>
							<input type="hidden" class="form-control input-sm" name="proforma" placeholder="Numero Proforma..." value="{{$proforma ? $proforma->id:''}}" required>
						</div>

						<div class="col-lg-1">
							<button class="btn btn-sm" form="importar" type="submit">Importar</button>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >Guia N°:</label>
						<div class="col-lg-2">
							<input type="number" class="form-control input-sm" name="numero" placeholder="Numero Guia..." value="{{ Input::old('guia') ? Input::old('guia') : '' }}" required>
						</div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >Aduana:</label>
            <div class="col-lg-2">
              <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="aduana" required>
                <option value="">Seleccionar Adauna...</option>
                @foreach ($aduanas as $aduana)
                  <option value="{{$aduana->id}}">{{$aduana->descripcion}}</option>
                @endforeach
              </select>
            </div>

            <label class="control-label col-lg-1" >Fecha:</label>
						<div class="col-lg-2">
							<input type="date" class="form-control input-sm" name="fecha" value="{{ Input::old('fecha') ? Input::old('fecha') : '' }}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1" >M/N:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="mn" placeholder="Moto Nave..." value="{{ Input::old('mn') ? Input::old('mn') : '' }}" required>
						</div>

            <label class="control-label col-lg-1" >BK:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="booking" placeholder="Booking..." value="{{ Input::old('bk') ? Input::old('bk') : '' }}" required>
						</div>

            <label class="control-label col-lg-1" >CONT:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="contenedor" placeholder="Contenedor..." value="{{ Input::old('cont') ? Input::old('cont') : '' }}" required>
						</div>

            <label class="control-label col-lg-1" >SELLO:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="sello" placeholder="Sello..." value="{{ Input::old('sello') ? Input::old('sello') : '' }}" required>
						</div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >CHOFER:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="chofer" placeholder="Nombre Chofer..." value="{{ Input::old('chofer') ? Input::old('chofer') : '' }}" required>
						</div>

            <label class="control-label col-lg-1" >PATENTE:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="patente" placeholder="patente del Vehiculo..." value="{{ Input::old('patente') ? Input::old('patente') : '' }}" required>
						</div>

            <label class="control-label col-lg-1" >MOVIL:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="movil" placeholder="movil..." value="{{ Input::old('movil') ? Input::old('movil') : '' }}" required>
						</div>

						<label class="control-label col-lg-1" >PROF:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="prof" placeholder="" value="{{ Input::old('prof') ? Input::old('prof') : '' }}" required>
						</div>

          </div>

					<div class="form-group">



						<label class="control-label col-lg-1" >DUS:</label>
						<div class="col-lg-2">
							<input type="text" class="form-control input-sm" name="dus" placeholder="dus..." value="{{ Input::old('dus') ? Input::old('dus') : '' }}" required>
						</div>

            <label class="control-label col-lg-1">K.Neto:</label>
						<div class="col-lg-2">
							<input type="number" class="form-control input-sm" name="neto" placeholder="Peso Netos..." value="{{ Input::old('neto') ? Input::old('contacto') : '' }}" required>
						</div>

						<label class="control-label col-lg-1">K.Bruto:</label>
						<div class="col-lg-2">
							<input type="number" class="form-control input-sm" name="bruto" placeholder="Peso Bruto..." value="{{ Input::old('bruto') ? Input::old('bruto') : '' }}" required>
						</div>

					</div>

					<div class="form-group">

						<label class="control-label col-lg-1">Nota:</label>
						<div class="col-lg-11">
							<input type="text" class="form-control input-sm" name="nota" placeholder="Nota ...">
						</div>
					</div>

			</form>
			<!-- /form-horizontal -->
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

				 @if (!$proforma)
					 <td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
				 @else
					@foreach ($proforma->detalles as $detalle)
						<tr>
							<td class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">{{$detalle->id}}</th>
							<td>{{$detalle->descripcion}}</th>
							<td class="text-right">{{$detalle->cantidad}}</th>
							<td class="text-right">{{$detalle->precio}}</th>
							<td class="text-right">{{$detalle->descuento}}</th>
							<td class="text-right">{{$detalle->sub_total}}</th>
						</tr>
					@endforeach
				 @endif


        </tbody>

      </table>
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
