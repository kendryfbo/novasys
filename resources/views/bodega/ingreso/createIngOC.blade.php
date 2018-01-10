@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingreso Orden Compra</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarIngOC')}}">

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

					<input class="form-control input-sm" name="tipo_ingreso" type="hidden" value="{{$tipoIngreso}}" required readonly>

					<label class="control-label col-lg-1">O.C :</label>
					<div class="col-lg-4">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="ordenCompra" v-model.lazy="itemId" @change="loadItems" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="orden in ordenesCompra" :value="orden.id">@{{'Numero: '+ orden.numero + ' - Cliente: ' + orden.proveedor.descripcion}}</option>
                        </select>
                    </div>

                </div>
                <!-- /form-group -->

                <h5>Items</h5>

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
                <th class="text-center">#</th>
                <th class="text-center">CODIGO</th>
                <th class="text-center">INSUMO</th>
                <th class="text-center">CANTIDAD</th>
                <th class="text-center">UNIDAD</th>
                <th class="text-center">RECIBIDAS</th>
                <th class="text-center">FECHA VENC</th>

              </tr>

            </thead>

            <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>
				<tr v-if="items" v-for="(item,key) in items">
					<td class="text-center">@{{key+1}}</td>
				    <td class="text-center">@{{item.codigo}}</td>
				    <td class="text-left">@{{item.descripcion}}</td>
				    <td class="text-right">@{{item.cantidad}}</td>
				    <td class="text-right">@{{item.unidad}}</td>
					<td class="input-td">
						<input class="form-control text-right" type="number" value="0" min="0" step="0.01" @change="updateRecibidas(item.id)">
					</td>
					<td class="input-td">
						<input class="form-control text-center" type="date" @change="updateFechaVenc(item.id)">
					</td>
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

	var ordenesCompra = Object.values({!!$ordenesCompra!!});
	</script>

    <script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/createIngOC.js')}}"></script>
@endsection
