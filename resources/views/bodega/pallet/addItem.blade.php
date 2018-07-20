@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Agregar Producto a Pallet</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarItemPallet')}}">

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
                        <input class="form-control input-sm" type="number" value="{{$pallet->numero}}" required readonly>
                        <input class="form-control input-sm" name="pallet_id" type="hidden" value="{{$pallet->id}}" required readonly>
                    </div>

                    <label class="control-label col-lg-1">Tamaño:</label>
        			<div class="col-lg-1">
						<input class="form-control input-sm" type="text" value="{{$pallet->medida->descripcion}}" required readonly>
        			</div>

                </div>
                <!-- /form-group -->

				<!-- form-group -->
                <div class="form-group">
					<!-- Bloque de condiciones - POR IMPLEMENTAR -->
                </div>
                <!-- /form-group -->

                <h5>Productos</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Producto:</label>
                    <div class="col-lg-6">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemId" @change="loadItem" :required="items.length <= 0">
                            <option value=""> </option>
						    <option v-for="producto in productos" :value="producto.id">@{{'Ingreso #'+ producto.ing_num + ' - ' + producto.descripcion + ' Por Procesar: ' + producto.por_procesar}}</option>
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
                <th class="text-center">DESCRIPCION</th>
                <th class="text-center">FECHA ING.</th>
                <th class="text-center">INGRESADAS</th>
              </tr>

            </thead>

            <tbody>
				<tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.producto_id)">
					<td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs" name="button" @click="removeItem(item)"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </td>
					<td class="text-center">@{{key+1}}</td>
					<td class="text-center">@{{item.codigo}}</td>
				    <td class="text-left">@{{item.descripcion}}</td>
				    <td class="text-center">@{{item.fecha_ing}}</td>
				    <td class="text-right">@{{item.cantidad}}</td>
				</tr>
				<tr v-if="detalles" v-for="(detalle,key) in detalles">
					<td class="text-center">
                    </td>
					<td class="text-center">@{{key+1}}</td>
					<td class="text-center">@{{detalle.producto.codigo}}</td>
				    <td class="text-left">@{{detalle.producto.descripcion}}</td>
				    <td class="text-center">@{{detalle.fecha_ing}}</td>
				    <td class="text-right">@{{detalle.cantidad}}</td>
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
		var productos = {!!json_encode($productos)!!};
		var detalles = {!!$pallet->detalles!!};
	</script>

    <script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/addItemToPallet.js')}}"></script>
@endsection
