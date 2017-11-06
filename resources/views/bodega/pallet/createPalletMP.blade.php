@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Creacion Pallet Materia Prima</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletProduccion')}}">

				{{ csrf_field() }}


				<h5>Bodega</h5>

				<!-- form-group -->
				<div class="form-group">

					<label class="control-label col-lg-1">Bodega:</label>
					<div class="col-lg-3">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodega" required>
							<option value=""> </option>
							@foreach ($bodegas as $bodega)
								<option {{Input::old('bodega') ? 'selected':''}} value="{{$bodega->id}}">{{$bodega->descripcion}}</option>
							@endforeach
						</select>
					</div>

				</div>
				<!-- /form-group -->
				<hr>
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


                    <label class="control-label col-lg-1">Tamaño:</label>
        			<div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="medida" required>
                             <option value=""> </option>
                        @foreach ($medidas as $medida)
                             <option {{Input::old('medida') ? 'selected':''}} value="{{$medida->id}}">{{$medida->descripcion}}</option>
                        @endforeach
                        </select>
        			</div>

                    <label class="control-label col-lg-2">Fecha Ingreso:</label>
        			<div class="col-lg-2">
        				<input class="form-control input-sm" type="date" name="fecha_prod" required>
        			</div>

                </div>
                <!-- /form-group -->

				<hr>
                <h5>Insumos</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Insumo:</label>
                    <div class="col-lg-4">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemId" @change="loadItem" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="insumo in insumos" :value="insumo.id">@{{insumo.descripcion}}</option>
                        </select>
                    </div>

					<label class="control-label col-lg-1">Unidad:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="unidad" :value="item.unidad_med" required readonly>
					</div>
					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" name="cantidad" v-model="cantidad" required>
					</div>

					<div class="col-lg-2">
					    <button :disabled="itemId == ''" class="btn btn-sm btn-default" type="button" name="addItem" @click="addItem">Agregar</button>
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
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">UNIDAD</th>
                <th class="text-center">CANTIDAD</th>
              </tr>

            </thead>

            <tbody>
				<tr v-if="items <= 0">
					<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
				</tr>
				<tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.producto_id)">
					<td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(item)"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </td>
					<td class="text-center">@{{key+1}}</td>
				    <td class="text-left">@{{item.descripcion}}</td>
				    <td class="text-right">@{{item.unidad_med}}</td>
				    <td class="text-right">@{{item.cantidad}}</td>
				</tr>

            </tbody>

          </table>

          <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>

        </div>
        <!-- /box-footer -->
    </div>
    <!-- /box -->


@endsection

@section('scripts')
	<script>
		var insumos = Object.values({!!$insumos!!});
	</script>

    <script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/createPalletMP.js')}}"></script>
@endsection
