@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion de Pallet Manual</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletManual')}}">

				{{ csrf_field() }}

                <h5>Pallet</h5>

                <!-- form-group -->
                <div class="form-group">


                    <div class="col-lg-offset-1 col-lg-2">
                        {!!$barCode!!}
                    </div>
                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Nº Pallet:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="numero" type="number" value="{{$numero}}" required readonly>
                    </div>
					<input class="form-control input-sm" name="tipo_ingreso" type="hidden" value="{{$tipoIngreso}}" required readonly>

                    <label class="control-label col-lg-1">Tamaño:</label>
        			<div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="medida" required>
                             <option value=""> </option>
                        @foreach ($medidas as $medida)
                             <option {{Input::old('medida') ? 'selected':''}} value="{{$medida->id}}">{{$medida->descripcion}}</option>
                        @endforeach
                        </select>
        			</div>

                </div>
                <!-- /form-group -->

				<!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Condicion:</label>
        			<div class="col-lg-3">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="codicion">
                             <option value=""> </option>
                        </select>
        			</div>

                    <label class="control-label col-lg-1">Opcion:</label>
        			<div class="col-lg-2">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="opcion">
                             <option value=""> </option>
                        </select>
        			</div>

                </div>
                <!-- /form-group -->

                <h5>Items</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Tipo:</label>
                    <div class="col-lg-2">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="tipoId" @change="loadItem" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="tipo in tipoProducto" :value="tipo.id">@{{tipo.descripcion}}</option>
                        </select>
                    </div>

                    <label class="control-label col-lg-1">Item:</label>
                    <div class="col-lg-4">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemId" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>
                        </select>
                    </div>

					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" name="cantidad" type="number" v-model="cantidad" required>
							<span class="input-group-addon">UNI</span>
						</div>
                    </div>

					<div class="col-lg-1">
					    <button :disabled="itemId == '' || cantidad == ''" class="btn btn-sm btn-default" type="button" name="addItem" @click="addItem">Agregar</button>
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

          <table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

            <thead>

              <tr>
                <th class="text-center"></th>
                <th class="text-center">#</th>
                <th class="text-center">CODIGO</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">CANTIDAD</th>
              </tr>

            </thead>

            <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>
				<tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.producto_id)">
					<td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(item)"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </td>
					<td class="text-center">@{{key+1}}</td>
				    <td class="text-left">@{{item.codigo}}</td>
				    <td class="text-right">@{{item.descripcion}}</td>
				    <td class="text-right">@{{item.cantidad}}</td>
				</tr>

            </tbody>

          </table>

			<div class="row">

				<div class=" col-sm-3 pull-right">
					<table class="table table-condensed table-bordered table-custom display" cellspacing="0" width="100%">

						<tr>
						<th class="bg-gray text-right">TOTAL:</th>
						<th class="text-right">@{{totalCantidad}}</th>
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

	var tipoProducto = Object.values({!!$tipoProducto!!});
	</script>

    <script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/createPalletManual.js')}}"></script>
@endsection
