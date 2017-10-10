@extends('layouts.master2')

@section('content')

    <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision de Nota de Debito</h4>
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
    		<form class="form-horizontal"  id="create" method="post" action="">

                <h5>Documento</h5>

                <!-- form-group -->
                <div class="form-group form-group-sm">

                    <label class="control-label col-lg-2">Nota Debito N°:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" type="text" name="numero" value="{{$notaCredito->numero}}" readonly>
                    </div>

                    <label class="control-label col-lg-1">Nota Credito:</label>
                    <div class="col-lg-1">
                        <input laceholder="Numero..." class="form-control input-sm" name="factura" type="number" min="0" value="{{$notaCredito->numero}}" readonly>
                    </div>

                </div>
                <!-- /form-group -->

                <h5>Datos</h5>

                <!-- form-group -->
                <div class="form-group">

                  <label class="control-label col-lg-1">Fecha:</label>
                  <div class="col-lg-2">
                    <input class="form-control input-sm" name="fecha" type="date" value="{{$notaCredito->fecha}}" readonly>
                  </div>

                </div>
                <!-- /form-group -->

		        <!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Cliente:</label>
					<div class="col-lg-4">
						<input class="form-control input-sm" type="text" name="cliente" value="{{$factura->cliente}}" readonly>
					</div>

					<label class="control-label col-lg-2">Condicion Pago:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="formaPago" value="{{$factura->cond_pago}}" readonly>
					</div>

		        </div>
		        <!-- /form-group -->
				<hr>
				<!-- form-group -->
		        <div class="form-group">

					<label class="control-label col-lg-1">Nota:</label>
					<div class="col-lg-8">
						<input class="form-control input-sm" type="text" name="nota" value="Anula Nota Credito {{$notaCredito->numero}}" readonly>
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
            <th class="text-center">DESC</th>
            <th class="text-center">TOTAL</th>
          </tr>

        </thead>

        <tbody>

			@foreach ($notaCredito->detalles as $detalle)
				<tr>
					<td class="text-right">{{$loop->iteration}}</td>
					<td class="text-center">{{$detalle->codigo}}</td>
					<td>{{$detalle->descripcion}}</td>
					<td class="text-right">{{$detalle->cantidad}}</td>
					<td class="text-right">{{$detalle->precio}}</td>
					<td class="text-center">{{$detalle->descuento}}</td>
					<td class="text-right">{{$detalle->sub_total}}</td>
				</tr>
			@endforeach

        </tbody>

      </table>

      <div class="row">

		  <div class=" col-sm-3 col-md-offset-9">
  			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

  					<tr>
  						<th class="bg-gray text-right">Sub-Total:</th>
  						<td class="input-td text-right">
							{{number_format($notaCredito->neto,0,',','.')}}
						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">Neto:</th>
  						<td class="input-td text-right">
							{{number_format($notaCredito->neto,0,',','.')}}
  						</td>
  					</tr>

					<!--
  					<tr>
  						<th class="bg-gray text-right">IABA:</th>
  						<td class="input-td">
							<moneda-input-readonly v-model="iaba"></moneda-input-readonly>
  						</td>
  					</tr>
					-->

  					<tr>
  						<th class="bg-gray text-right">I.V.A:</th>
  						<td class="input-td text-right">
							{{number_format($notaCredito->iva,0,',','.')}}
  						</td>
  					</tr>

  					<tr>
  						<th class="bg-gray text-right">TOTAL:</th>
  						<th class="bg-gray input-td text-right">
							{{number_format($notaCredito->total,0,',','.')}}
  						</th>
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
<script>
	var productos = {!! $factura ? $factura->detalles->toJson() : "[]" !!};
	var sub_total = 0; //{!! $factura ? $factura->sub_total : "[]" !!};
	var descuentoTotal = 0; //{!! $factura ? $factura->descuento : "[]" !!};
	var neto = 0; //{!! $factura ? $factura->neto : "[]" !!};
	var iaba = 0; //{!! $factura ? $factura->iaba : "[]" !!};
	var iva = 0; //{!! $factura ? $factura->iva : "[]" !!};
	var total = 0; //{!! $factura ? $factura->total : "[]" !!};
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('vue/components/formatos-inputs.js')}}"></script>
<script src="{{asset('js/comercial/createNotaCredito.js')}}"></script>
@endsection
