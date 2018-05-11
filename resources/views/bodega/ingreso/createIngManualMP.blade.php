@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingreso Manual Materia Prima</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarIngManualMP')}}">

				{{ csrf_field() }}

                <h5>Datos</h5>



                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Numero:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="numero" type="text" value="Nuevo" required readonly>
                    </div>
                    <label class="control-label col-lg-1">Fecha:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="fecha" type="date" value="{{$fecha}}" required readonly>
                    </div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Descripcion:</label>
                    <div class="col-lg-5">
                        <input class="form-control input-sm" name="descripcion" type="text" required>
                    </div>
					<input class="form-control input-sm" name="tipo_ingreso" type="hidden" value="{{$tipoIngreso}}" required readonly>
					<input class="form-control input-sm" name="tipo_prod" type="hidden" value="{{$tipoProd}}" required readonly>

                </div>
                <!-- /form-group -->

                <h5>Items</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Insumo:</label>
                    <div class="col-lg-3">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model.lazy="itemId" @change="loadItem" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="insumo in insumos" :value="insumo.id">@{{insumo.descripcion}}</option>
                        </select>
                    </div>

					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control input-sm" type="number" v-model.number.lazy="cantidad" required>
							<span class="input-group-addon">@{{item.unidad_med}}</span>
						</div>
                    </div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

					<label class="control-label col-lg-1">Venc:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" v-model="fecha_venc" type="date">
					</div>

					<label class="col-lg-offset-1 control-label col-lg-1">Nº Lote:</label>
					<div class="col-lg-3">
						<input class="form-control input-sm" v-model="lote" type="text">
					</div>

					<div class="col-lg-1">
						<button :disabled="itemId == '' || cantidad == '' || cantidad <= 0 " class="btn btn-sm btn-default" type="button" name="addItem" @click="addItem">Agregar</button>
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
                <th class="text-center">INSUMO</th>
                <th class="text-center">CANTIDAD</th>
              </tr>

            </thead>

            <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>
				<tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.id)">
					<td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(item)"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </td>
					<td class="text-center">@{{key+1}}</td>
				    <td class="text-center">@{{item.codigo}}</td>
				    <td class="text-left">@{{item.descripcion}}</td>
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
	<script src="{{asset('js/bodega/createIngManualMP.js')}}"></script>
@endsection
