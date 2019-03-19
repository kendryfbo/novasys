@extends('layouts.master2')

@section('content')

    <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Emisión Nota de Crédito Cliente</h4>
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
			<form id="create" class="form-horizontal" method="post" action="{{route('guardarNotaCreditoNacCliente')}}">

				{{ csrf_field() }}
				<input type="hidden" name="group" value="{{$busqueda ? $busqueda->group : ''}}">
                <!-- form-group -->
                <div class="form-group form-group-sm">

                <label class="control-label col-lg-1">Nota Crédito N°:</label>
                <div class="col-lg-1">
                    <input class="form-control input-sm" type="numero"  min="0" name="numero" autofocus required>
                </div>

				<input class="form-control input-sm" type="hidden"  min="0" name="factura" value="0" required>
            </div>
            <!-- /form-group -->

    				<!-- form-group -->
            <div class="form-group form-group-sm">

                <label class="control-label col-lg-1">Fecha:</label>
                <div class="col-lg-2">
                    <input class="form-control input-sm" type="date" name="fecha" required>
                </div>

            </div>
            <!-- /form-group -->

            <!-- form-group -->
            <div class="form-group form-group-sm">

				<label class="control-label col-lg-1">Cliente:</label>
				<div class="col-lg-4">
					<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="cliente" required>
						<option value=""></option>
						@foreach ($clientes as $cliente)

							<option {{Input::old('clausula') ? 'selected':''}} value="{{$cliente->id}}">{{$cliente->descripcion}}</option>

						@endforeach
					</select>
              	</div>

				<label class="control-label col-lg-2">Con IABA:</label>
				<div class="col-lg-2 checkbox">
					<input type="checkbox" name="statusIABA" v-model="statusIABA" @change="calculateTotal">
				</div>

            </div>
            <!-- /form-group -->

			<!-- form-group -->
            <div class="form-group form-group-sm">

              <label class="control-label col-lg-1">Nota:</label>
              <div class="col-lg-8">
                <input class="form-control input-sm"type="text" name="nota" placeholder="Observación Nota de Venta...">
              </div>

            </div>
            <!-- /form-group -->

			<!-- Items -->
			<select style="display: none;"  name="items[]" multiple>
				<option v-for="item in items" selected>
					@{{item}}
				</option>
			</select>
			<!-- /items -->

        </form>
        <!-- /form -->

    </div>
    <!-- /box-body -->

    <!-- box-footer -->
    <div class="box-footer">

        <h5>Detalle</h5>

        <div class="form-horizontal">

            <div class="form-group form-group-sm">

                <label class="control-label col-lg-1">Descripción:</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="descripcion" v-model="descripcion" value="">
                </div>

                <label class="control-label col-lg-1">Monto:</label>
                <div class="col-lg-2">
					<moneda-input v-model.number="monto"></moneda-input>
                </div>

                <div class="col-lg-1">
                    <button type="button" class="btn btn-default btn-sm" name="button" @click="addItem">Agregar</button>
                </div>

            </div>

        </div>

        <table class="table table-condensed table-bordered table-custom display nowrap" cellspacing="0" width="100%">

            <thead>

                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">#</th>
                    <th class="text-center">DESCRIPCION</th>
                    <th class="text-center">MONTO</th>
                </tr>

            </thead>

            <tbody>
				<tr>
					<td v-if="items <= 0" colspan="4" class="text-center">Tabla sin datos...</td>
				</tr>
                <tr v-for="(item, index) in items">
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(item)"><i class="fa fa-times-circle" aria-hidden="true" ></i></button>
                    </td>
                    <td class="text-center">@{{index + 1}}</td>
                    <td class="text-left">@{{item.descripcion}}</td>
                    <td class="text-right">CLP$ @{{numberFormat(item.precio)}}</td>
                </tr>

            </tbody>

        </table>

        <div class="row">

            <div class=" col-sm-3 col-md-offset-9">

                <table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

					<tr>
						<th class="bg-gray text-right">NETO $</th>
						<th class="text-right">@{{numberFormat(neto)}}</th>
					</tr>
					<tr>
						<th class="bg-gray text-right">IABA $</th>
						<th class="text-right">@{{numberFormat(iaba)}}</th>
					</tr>
					<tr>
						<th class="bg-gray text-right">IVA $</th>
						<th class="text-right">@{{numberFormat(iva)}}</th>
					</tr>
					<tr>
                        <th class="bg-gray text-right">TOTAL $</th>
                        <th class="text-right">@{{numberFormat(total)}}</th>
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
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('vue/components/formatos-inputs.js')}}"></script>
<script src="{{asset('js/comercial/createNotaCredNacCliente.js')}}"></script>
@endsection
