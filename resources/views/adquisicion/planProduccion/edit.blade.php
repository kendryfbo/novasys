@extends('layouts.masterFinanzas')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Edicion Plan de Produccion</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="edit" class="form-horizontal" action="{{route('actualizarPlanProduccion',['id' => $planProduccion->id])}}" method="post">
				{{ csrf_field() }}

				<h5>Seleccion de Producto Terminado</h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Descripcion:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="descripcion" value="{{$planProduccion->descripcion}}">
					</div>
					<label class="control-label col-lg-1">Fecha:</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="date" name="fecha_emision" value="{{$planProduccion->fecha_emision}}">
					</div>

				</div>
				<hr>
				<div class="form-group">

					<label class="control-label col-lg-1">Producto:</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="itemID">
							<option value=""></option>
							<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

						</select>
					</div>
					<label class="control-label col-lg-1">Cantidad:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="number" value="0" min="0" v-model.number="cantidad">
					</div>

					<label class="control-label col-lg-1">Máquina:</label>
					<div class="col-lg-1">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="maquina" v-model="maquina">
									@foreach ($maquinas as $maquina)
									<option value="{{$maquina->maquina}}">{{$maquina->maquina}}</option>
									@endforeach
						</select>
					</div>

					<label class="control-label col-lg-1">Día:</label>
					<div class="col-lg-1">
										<select name="diaSemana" v-model="dia">
											@foreach ($dias as $dia)
											<option value="{{$dia->dia}}">{{$dia->dia}}</option>
											@endforeach
										</select>
					</div>

					<label class="control-label col-lg-1">Destino	:</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="destino" v-model="destino" value="{{$planProduccion->destino}}">
					</div>


					<div class="col-lg-1">
						<button id="addItem" class="btn btn-sm btn-default" type="button" name="button" @click="addItem">Agregar</button>
					</div>

				</div>

				<div class="form-group">

					<!-- Items -->
					<select style="display: none;"  name="items[]" multiple required>
						<option v-for="item in items" selected>
							@{{item}}
						</option>
					</select>
					<!-- /items -->

				</div>

			</form>
		</div>

		<div class="box-body">
			<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">

			  <thead>
				<tr>
				  <th class="text-center">#</th>
				  <th class="text-center"></th>
				  <th class="text-center">CÓDIGO</th>
				  <th class="text-center">DESCRIPCIÓN</th>
				  <th class="text-center">CANTIDAD</th>
					<th class="text-center">MÁQUINA</th>
					<th class="text-center">DÍA</th>
					<th class="text-center">DESTINO</th>
				</tr>
			  </thead>

			  <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>

				<tr v-if="items" v-for="(item,key) in items">
				  <td class="text-center">@{{key+1}}</td>
				  <td class="text-center">
				  	<button class="btn btn-sm btn-danger" type="button" name="button" @click="removeItem(item.id)">
					  <i class="fa fa-times-circle" aria-hidden="true"></i>
				  	</button>
				  </td>
				  <td class="text-center">@{{item.codigo}}</td>
				  <td>@{{item.descripcion}}</td>
				  <td class="text-right">@{{item.cantidad.toLocaleString()}}</td>
					<td class="text-center">@{{item.maquina}}</td>
					<td class="text-center">@{{item.dia}}</td>
					<td class="text-center">@{{item.destino}}</td>
				</tr>

			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			 <button form="edit" class="btn btn-default pull-right" type="submit">Actualizar</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script>
		productos = {!!$productos!!};
		items = {!!$planProduccion->detalles->toJson()!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/adquisicion/planProduccionEdit.js')}}"></script>
@endsection
