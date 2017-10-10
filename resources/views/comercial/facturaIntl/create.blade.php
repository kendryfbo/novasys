@extends('layouts.master2')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emision Factura Internacional</h4>
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
			<form id="importProforma" action="{{route('importProformaFactIntl')}}" method="post">
				{{ csrf_field() }}
			</form>
			<!-- /form -->

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('notasVentas.store')}}">

				{{ csrf_field() }}

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Factura N°:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="numero"  min="0" autofocus required>
          </div>


					<label class="control-label col-lg-1 col-lg-offset-4">Proforma:</label>
					<div class="col-lg-1">
						<input form="importProforma" class="form-control input-sm" type="number" name="proforma">
					</div>
					<button form="importProforma" class="col-lg-1 btn btn-default btn-sm" type="submit" name="button">Importar</button>
					<div class="col-lg-2">
						@if (session('status'))
							<p class="control-label text-red text-left">{{session('status')}}</p>
						@endif
					</div>

        </div>
        <!-- /form-group -->

				<!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Emision:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" type="date" name="emision">
          </div>

          <label class="control-label col-lg-1">Vencimiento:</label>
          <div class="col-lg-2">
            <input class="form-control input-sm" type="date" name="vecimiento">
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">C. Venta:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
              @foreach ($centrosVenta as $centro)

                <option value="{{$centro->id}}">{{$centro->descripcion}}</option>

              @endforeach
            </select>
          </div>

          <label class="control-label col-lg-1">Clausula:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
							@foreach ($clausulas as $clausula)

								<option value="{{$clausula->id}}">{{$clausula->nombre}}</option>

							@endforeach
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Cliente:</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
							@foreach ($clientes as $cliente)

								<option value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-2">Medio Transporte:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
							@foreach ($transportes as $transporte)

								<option value="{{$transporte->id}}">{{$transporte->descripcion}}</option>

							@endforeach
            </select>
          </div>

        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Puerto E. :</label>
          <div class="col-lg-4">
            <select class="selectpicker" data-width="400" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
              <option value=""></option>
							@foreach ($aduanas as $aduana)

								<option value="{{$aduana->descripcion}}">{{$aduana->descripcion}}</option>

							@endforeach
            </select>
          </div>

          <label class="control-label col-lg-2">Condicion Pago:</label>
          <div class="col-lg-2">
            <select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-sm btn-default" name="centroVenta" required>
							<option value=""></option>
            </select>
          </div>


        </div>
        <!-- /form-group -->

        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Direccion:</label>
          <div class="col-lg-5">
            <input class="form-control input-sm"type="text" name="direccion">
          </div>

          <label class="control-label col-lg-1">Puerto D. :</label>
          <div class="col-lg-4">
            <input class="form-control input-sm" type="text" name="direccion" value="">
          </div>

        </div>
        <!-- /form-group -->

        <h5>Detalle</h5>
        <!-- form-group -->
        <div class="form-group">

          <label class="control-label col-lg-1">Producto:</label>
          <div class="col-lg-2">
            <select id="prodSelect" class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" required>
				<option value="">Tabla sin datos...</option>
            </select>
          </div>

          <label class="control-label col-lg-1">Cant:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" name="cantidad" v-model.number="cantidad">
          </div>

          <label class="control-label col-lg-1">% desc:</label>
          <div class="col-lg-1">
            <input class="form-control input-sm" type="number" min="0" max="100" name="descuento" v-model.number="descuento" value="0">
          </div>

          <label class="control-label col-lg-1">precio:</label>
          <div class="col-lg-2">
            <input id="precio" class="form-control input-sm" type="number" min="0" name="precio" v-model.number="precio">
          </div>

          <div class="col-lg-2">
            <button class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
            <button class="btn btn-sm btn-default" type="button" name="button" @click="removeItem">Borrar</button>
          </div>

        </div>
        <!-- /form-group -->

      </form>
      <!-- /form -->

    </div>
    <!-- /box-body -->

    <!-- box-footer -->
    <div class="box-footer">

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

			<tr>
				<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
			</tr>

        </tbody>

      </table>

      <div class="row">
        <div class=" col-sm-3">
          <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

              <tr>
                <th class="bg-gray text-right">Peso Neto:</th>
                <td class="text-right">0.00</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Peso Bruto:</th>
                <td class="text-right">0.00</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Volumen:</th>
                <td class="text-right">0.00</th>
              </tr>
              <tr>
                <th class="bg-gray text-right">Cant. Cajas:</th>
                <td class="text-right">0.00</th>
              </tr>


          </table>
        </div>
        <div class=" col-sm-3 col-md-offset-6">
			<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

				<tr>
					<th class="bg-gray text-right">TOTAL F.O.B.:</th>
					<th class="text-right">0.00</th>
				</tr>
				<tr>
					<th class="bg-gray text-right">FREIGHT:</th>
					<td class="input-td">
						<input id="freight" class="form-control text-right" type="number" name="freight" min="0" step="0.01" v-model.number="freight" @change="freightChange">
					</td>
				</tr>
				<tr>
					<th class="bg-gray text-right">INSURANCE:</th>
					<td class="input-td">
						<input class="form-control text-right" type="number" lang="es" min="0" step="0.01" name="insurance" v-model.number="insurance" @change="insuranceChange">
					</td>
				</tr>
				<tr>
					<th colspan="2" class=""></th>
				</tr>
				<tr>
					<th class="bg-gray text-right">TOTAL:</th>
					<th class="bg-gray text-right">0.00</th>
				</tr>

			</table>
        </div>

      </div>

      <button class="btn btn-default pull-right" type="button" name="button" disabled>Crear</button>
    </div>
    <!-- /box-footer -->


  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
@endsection
