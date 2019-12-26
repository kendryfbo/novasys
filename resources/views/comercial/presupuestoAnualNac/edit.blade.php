@extends('layouts.master2')

@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Edición	Proyección de Ventas Internacional</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<form id="edit" class="form-horizontal" action="{{route('actualizarPresupuestoIntl',['id' => $presupuestoIntl->id])}}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<h5></h5>

				<div class="form-group">

					<label class="control-label col-lg-1">Año :</label>
					<div class="col-lg-2">
						<input class="form-control input-sm" type="text" name="year" value="{{$presupuestoIntl->year}}" required>
					</div>
				</div>
				<hr>

				<div class="form-group">
					<label class="control-label col-lg-1">Meses :</label>
					<div class="col-lg-2">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="mesID">
							<option value=""></option>
							<option v-for="mes in meses" :value="mes.id">@{{mes.descripcion}}</option>

						</select>
					</div>

					<label class="control-label col-lg-1">Monto en USD :</label>
					<div class="col-lg-1">
						<input class="form-control input-sm" type="text" name="amount" v-model="amount" value="">
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
				  <th class="text-center">MES</th>
				  <th class="text-center">MONTO EN USD</th>
				</tr>
			  </thead>

			  <tbody>
				<tr v-if="items <= 0">
					<td colspan="8" class="text-center" >Tabla Sin Datos...</td>
				</tr>

				<tr v-if="items" v-for="(item,key) in items">
				  <td class="text-center">@{{key+1}}</td>
				  <td class="text-center">
				  	<button class="btn btn-sm btn-danger" type="button" name="button" @click="removeItem(key)">
					  <i class="fa fa-times-circle" aria-hidden="true"></i>
				  	</button>
				  </td>
					<td class="text-left">@{{item.month}}</td>
				  <td class="text-left">@{{item.amount}}</td>
				</tr>

			  </tbody>

			</table>
		</div>

		<div class="box-footer">
			 <button form="edit" class="btn btn-default pull-right" name="button" value="1" type="submit">Actualizar</button>
		</div>


	</div>
@endsection

@section('scripts')
	<script>
		meses = {!!$meses!!};
		items = {!!$presupuestoIntlDetalle->toJson()!!};
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/comercial/presupuestoAnualIntlEdit.js')}}"></script>
@endsection
