@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Packing List</h4>

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

			<form id="import" action="{{route('crearPackingList')}}" method="get">

			</form>
			<!-- form-horizontal -->
			<form  id="pdf" class="form-horizontal" method="post" action="{{route('pdfPackingList')}}">

				{{ csrf_field() }}

					<div class="form-group">

            <label class="control-label col-lg-1" >Guia N°:</label>
            <div class="col-lg-2">
              <input form="import" type="number" class="form-control input-sm" name="guia" placeholder="Numero Guia..." value="{{$guia ? $guia->numero : ''}}" required>
              <input type="hidden" class="form-control input-sm" name="guia" placeholder="Numero Guia..." value="{{$guia ? $guia->id : ''}}" required>
            </div>

						<div class="col-lg-1">
							<button form="import" class="btn btn-sm btn-default" type="submit">Importar</button>
						</div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >Factura N°:</label>
            <div class="col-lg-2">
              <input type="number" class="form-control input-sm" name="factura" placeholder="Numero Factura..." value="{{ Input::old('factura') ? Input::old('factura') : '' }}" required>
            </div>

					</div>

					<div class="form-group">

            <label class="control-label col-lg-1" >Contenedor:</label>
            <div class="col-lg-2">
              <input type="number" class="form-control input-sm" name="contenedor" placeholder="Numero Contenedor..." value="{{$guia ? $guia->contenedor : ''}}" readonly required>
            </div>

					</div>

			</form>
			<!-- /form-horizontal -->
      <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

        <thead>

          <tr>
            <th class="text-center">#</th>
						<th class="text-center">CANT</th>
            <th class="text-center">CODIGO</th>
            <th class="text-center">DESCRIPCION</th>
						<th class="text-center">FORMATO</th>
						<th class="text-center">PESO BRUTO</th>
            <th class="text-center">PESO NETO</th>
            <th class="text-center">VOLUMEN</th>
          </tr>

        </thead>

        <tbody>

					@if (!$guia)

						<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>

					@else

						@foreach ($guia->detalles as $detalle)

							<tr>
								<td class="text-center">{{$loop->iteration}}</td>
								<td class="text-center">{{$detalle->cantidad}}</td>
								<td>{{$detalle->producto->codigo}}</td>
								<td>{{$detalle->producto->descripcion}}</td>
								<td class="text-right">{{$detalle->producto->formato->descripcion}}</td>
								<td class="text-right">{{$detalle->producto->peso_bruto}}</td>
								<td class="text-right">{{$detalle->producto->peso_neto}}</td>
								<td class="text-right">{{$detalle->producto->volumen}}</td>
							</tr>

						@endforeach

					@endif

        </tbody>

      </table>
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="pdf" class="btn btn-sm btn-default pull-right"><i class="fa fa-print" aria-hidden="true"></i>Imprimir</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
