@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Packing List</h4>

			@if ($errors->any())

				@foreach ($errors->all() as $error)

					@component('components.errors.validation')
						@slot('errors')
							{{$error}}
						@endslot
					@endcomponent

				@endforeach

			@endif

		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form-horizontal -->
			<form  id="create" class="form-horizontal" method="post" action="{{route('generarPackingList',['guia'])}}">

				{{ csrf_field() }}

					<div class="form-group">

            <label class="control-label col-lg-1" >Guia N°:</label>
            <div class="col-lg-2">
              <input type="number" class="form-control input-sm" name="guia" placeholder="Numero Guia..." value="{{ Input::old('guia') ? Input::old('guia') : '' }}" required>
            </div>

					</div>

          <div class="form-group">

            <label class="control-label col-lg-1" >Factura N°:</label>
            <div class="col-lg-2">
              <input type="number" class="form-control input-sm" name="factura" placeholder="Numero Factura..." value="{{ Input::old('factura') ? Input::old('factura') : '' }}" required>
            </div>

					</div>

					<div class="form-group">

            <label class="control-label col-lg-1" >Contenedor:</label>
            <div class="col-lg-2">
              <input type="number" class="form-control input-sm" name="contenedor" placeholder="Numero Contenedor..." value="{{ Input::old('contenedor') ? Input::old('contenedor') : '' }}" required>
            </div>

					</div>

			</form>
			<!-- /form-horizontal -->
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

					<td colspan="7" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>

          <tr v-if="items" v-for="(item,key) in items" @click="loadItem(item.id)">
            <td class="text-center">@{{key+1}}</th>
            <td class="text-center">@{{item.codigo}}</th>
            <td>@{{item.descripcion}}</th>
            <td class="text-right">@{{item.cantidad.toLocaleString()}}</th>
            <td class="text-right">@{{item.precio.toLocaleString()}}</th>
            <td class="text-right">@{{item.descuento.toLocaleString()}}</th>
						<td class="text-right">@{{item.total.toLocaleString()}}</th>
          </tr>

        </tbody>

      </table>
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
