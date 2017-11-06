@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Lista de Precios</h4>
		</div>
		<!-- /box-header -->
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#lista">Lista</a></li>
		  <li><a data-toggle="tab" href="#detalle">Detalle Lista</a></li>
		</ul>
		<!-- tab-content -->
		<div class="tab-content">
			<!-- tab-panel -->
  			<div id="lista" class="tab-pane fade in active">
				<!-- box-body -->
				<div class="box-body">
					<!-- form -->
					<form  id="edit" method="post" action="{{route('listaPrecios.update',['listaPrecio' => $listaPrecio->id])}}">
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<!-- form-horizontal -->
						<div class="form-horizontal">

							<div class="form-group">
								<label class="control-label col-sm-2" >Descripcion:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="descripcion" placeholder="Nombre de lista de precios..." value="{{ $listaPrecio->descripcion }}" required>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2">Activo:</label>
								<div class="col-sm-4">
									<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $listaPrecio->activo ? "checked" : "" }}>
								</div>
							</div>

						</div>
						<!-- /form-horizontal -->
					</form>
					<!-- /form -->
				</div>
				<!-- /box-body -->
				<!-- box-footer -->
				<div class="box-footer">
		   	 		<button type="submit" form="edit" class="btn pull-right">Modificar</button>
		   	 	</div>
				<!-- /box-footer -->
			</div>
			<!-- /tab-panel -->
			<!-- tab-panel -->
  			<div id="detalle" class="tab-pane fade in">
				<!-- box-body -->
				<div class="box-body">
					<!-- form-inline -->
					<div id="create-detallelista" class="form-inline">

						<div class="form-group">
							<label>producto:</label>
							<div class="input-group" style=" padding-left: 10px">
								<select class="selectpicker" data-width="auto" data-live-search="true" data-style="btn-default" name="producto" v-model="producto" @change="getDescripcion" required>
									<option value="">Seleccionar Producto...</option>
									@foreach ($productos as $producto)
										<option value="{{$producto->id}}">{{$producto->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group" style="padding-left: 10px">
							<label>Precio:</label>
							<div class="input-group" >
								<input type="number" step="any" min="1" class="form-control" name="precio" v-model="precio" required>
							</div>
						</div>

						<div class="form-group" style=" padding-left: 20px">
							<button type="button" form="create-detallelista" class="btn pull-right" v-on:click="insertItem">Agregar</button>
						</div>

					</div>
					<!-- /form-inline -->
				</div>
				<!-- /box-body -->
				<!-- box-body -->
				<div class="box-body">
					<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>codigo</th>
								<th>decripcion</th>
								<th>precio</th>
								<th class="text-center">Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<td colspan="5" class="text-center" v-if="items <= 0">Tabla Sin Datos...</td>
							<tr v-for="(item,key) in items" @click="loadItem(item.id)">
								<th class="text-center" v-text="(key+1)"></th>
								<td>@{{ item.producto.codigo }}</td>
								<td>@{{ item.producto.descripcion }}</td>
								<td>@{{ item.precio }}</td>
								<td class="text-center">
									<button class="btn btn-sm" type="button" @click="deleteDetalle(item.id)">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /box-body -->
			</div>
			<!-- /tab-panel -->
		</div>
		<!-- /tab-content -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')
<<script>
	var lista ={!!$listaPrecio->id!!};
	var productos = {!!$productos!!};
	var items = {!!$listaPrecio->detalle!!}
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/listaPrecio.js')}}"></script>
@endsection
