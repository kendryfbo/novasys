@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Ingreso Manual Nuevo Pallet</h4>
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
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarPallet')}}">

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


                <h5>Pallet</h5>

                <!-- form-group -->
                <div class="form-group">


                    <div class="col-lg-offset-1 col-lg-2">
                        {!!$png!!}
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
        			<div class="col-lg-2">
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

                <h5>Producto</h5>

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Tipo:</label>
                    <div class="col-lg-2">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="tipo" required>
                            <option value=""> </option>
						@foreach ($tipos as $tipo)
						    <option {{Input::old('tipo') ? 'selected':''}} value="{{$tipos->id}}">{{$tipos->descripcion}}</option>
						@endforeach
                        </select>
                    </div>

                </div>
                <!-- /form-group -->

				<!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Producto:</label>
                    <div class="col-lg-3">
                      <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="producto" v-model="prodId" @change="updateVidaUtil" required>
                        <option value=""></option>
						<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

                      </select>
                    </div>

                    <label class="control-label col-lg-1">Unidad:</label>
                    <div class="col-lg-1">
						<input class="form-control input-sm" name="unidad_med" type="text" required readonly>
                    </div>

                    <label class="control-label col-lg-1">Cantidad:</label>
                    <div class="col-lg-1">
						<input class="form-control input-sm" name="cantidad" type="number" required>
                    </div>

                    <div class="col-lg-2">
					    <button class="btn btn-sm btn-default" type="button" name="add">Agregar</button>
                        <button class="btn btn-sm btn-default" type="button" name="remove">Eliminar</button>
                    </div>

                </div>
                <!-- /form-group -->

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
                <th class="text-center">DESCRIPCION</th>
                <th class="text-center">CANT</th>
                <th class="text-center">PRECIO</th>
                <th class="text-center">DESC</th>
                <th class="text-center">TOTAL</th>
              </tr>

            </thead>

            <tbody>
    					<tr v-if="items <= 0">
    						<td colspan="7" class="text-center" >Tabla Sin Datos...</td>
    					</tr>

              <tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.producto_id)">
                <td class="text-center">@{{key+1}}</td>
                <td class="text-center">@{{item.codigo}}</td>
                <td>@{{item.descripcion}}</td>
                <td class="text-right">@{{item.cantidad.toLocaleString()}}</td>
                <td class="text-right">@{{numberFormat(item.precio)}}</td>
                <td class="text-right">@{{numberFormat(item.descuento)}}</td>
    						<td class="text-right">@{{numberFormat(item.sub_total)}}</td>
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
	</script>

    <script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
@endsection
