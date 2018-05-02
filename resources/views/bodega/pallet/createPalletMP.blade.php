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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPalletMP')}}">

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

                    <label class="control-label col-lg-1">Fecha:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="fecha" type="date" value="{{$fecha}}" required readonly>
                    </div>

                    <label class="control-label col-lg-1">Tamaño:</label>
        			<div class="col-lg-2">
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
					<!-- Bloque de condiciones - POR IMPLEMENTAR -->
                </div>
                <!-- /form-group -->

                <h5>Materia Prima</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Producto:</label>
                    <div class="col-lg-7">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemId" @change="loadItem" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="insumo in insumos" :value="insumo.id">
								@{{'Ingreso N°'+insumo.ing_num+' - '+insumo.codigo +' - '+insumo.descripcion + ' - Cantidad: ' + insumo.por_procesar}}
							</option>
                        </select>
                    </div>

					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" v-model="cantidad">
                    </div>

					<div class="col-lg-2">
					    <button :disabled="itemId == '' || cantidad == '' || cantidad > item.por_almacenar" class="btn btn-sm btn-default" type="button" name="addItem" @click="addItem">Agregar</button>
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
                <th class="text-center">INSUMOS</th>
                <th class="text-center">UNIDAD</th>
                <th class="text-center">INGRESADAS</th>
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
					<td class="text-center">@{{item.codigo}}</td>
				    <td class="text-left">@{{item.descripcion}}</td>
				    <td class="text-center">@{{item.unidad_med}}</td>
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
