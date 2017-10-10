@extends('layouts.master2')

@section('content')

    <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Nota de Debito Intl</h4>
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
    		<!-- form Cargar Factura -->
    		<form id="import"  action="{{route('crearNotaDebitoIntl')}}" method="get">
    		</form>
    		<!-- /form -->
    		<!-- form -->
    		<form class="form-horizontal"  id="create" method="post" action="{{route('guardarNotaDebitoIntl')}}">

				{{ csrf_field() }}

                <h5>Documento</h5>

                <!-- form-group -->
                <div class="form-group form-group-sm">


                    <label class="control-label col-lg-1">N. Credito N°:</label>
                    <div class="col-lg-1">
                        <input form="import" placeholder="Numero..." class="form-control input-sm" name="notaCredito" type="number" min="0" value="{{$notaCredito ? $notaCredito->numero : '' }}" required>
                        <input class="form-control input-sm" name="notaCredito"  type="hidden" min="0" value="{{$notaCredito ? $notaCredito->numero : '' }}" required>
                    </div>

                    <div class="col-lg-1">
                        <button form="import" class="btn btn-sm btn-default" type="submit">Cargar</button>
                    </div>

					<label class="control-label col-lg-2">Nota Debito N°:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="numero" required>
					</div>

                </div>
                <!-- /form-group -->

                <h5>Datos</h5>

                <!-- form-group -->
                <div class="form-group">

                  <label class="control-label col-lg-1">Fecha:</label>
                  <div class="col-lg-2">
                    <input class="form-control input-sm" name="fecha" type="date" required>
                  </div>

                </div>
                <!-- /form-group -->

				<!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Nota:</label>
					<div class="col-lg-8">
						<input class="form-control input-sm" type="text" name="nota" v-model="nota" placeholder="Observacion o Motivo de Nota de debito">
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

		<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

			<thead>

				<tr>
					<th class="text-center">#</th>
					<th class="text-center">CODIGO</th>
					<th class="text-center">DESCRIPCION</th>
					<th class="text-center">CANT</th>
					<th class="text-center">PRECIO</th>
					<th class="text-center">TOTAL</th>
				</tr>

			</thead>

			<tbody>

				@if ($notaCredito)

					@foreach ($notaCredito->detalles as $detalle)

						<tr>
							<td class="text-center">{{$loop->iteration}}</td>
							<td class="text-center">{{$detalle->codigo}}</td>
							<td>{{$detalle->descripcion}}</td>
							<td class="text-right">{{$detalle->cantidad}}</td>
							<td class="text-right">{{ number_format($detalle->precio,0,',','.')}}</td>
							<td class="text-right">{{ number_format($detalle->sub_total ,0,',','.')}}</td>
						</tr>

					@endforeach

				@endif


			</tbody>

		</table>

      <div class="row">

		  <div class=" col-sm-3 col-md-offset-9">
  			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

  					<tr>
  						<th class="bg-gray text-right">F.O.B:</th>
  						<td class="input-td text-right">
							{{$notaCredito ? 'US$ ' . number_format($notaCredito->neto ,0,',','.'): ''}}
  						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">TOTAL:</th>
  						<th class="bg-gray input-td text-right">
							{{$notaCredito ? 'US$ ' . number_format($notaCredito->total,0,',','.') : ''}}
  						</th>
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

</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
