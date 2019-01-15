@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Crear Perfil de Acceso</h4>

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
			<form  id="create" class="form-horizontal" method="post" action="{{route('actualizarPerfilAcceso',['id' => $perfil->id])}}">

				{{ csrf_field() }}
                {{ method_field('PUT') }}

				<h5>Datos</h5>
		        <div class="form-group">
		          <label class="control-label col-lg-1" >Nombre:</label>
		          <div class="col-lg-2">
		            <input type="text" class="form-control input-sm" name="nombre" placeholder="Nombre del Perfiol..." value="{{$perfil->nombre}}" required>
		          </div>
		        </div>

				<div class="form-group">
					<label class="control-label col-lg-1" >Descripcion:</label>
					<div class="col-lg-5">
						<input type="text" class="form-control input-sm" name="descripcion" placeholder="Descripcion del Perfil..." value="{{$perfil->descripcion}}" required>
					</div>
					<div class="col-lg-2 col-lg-offset-4">
						<div class="btn-group" role="group" aria-label="...">
							<button type="button" class="btn btn-success btn-sm" @click="selectAll()">Todos</button>
							<button type="button" class="btn btn-danger btn-sm" @click="unSelectAll()">Ninguno</button>
						</div>
					</div>
				</div>

				<div class="form-group">

					<label class="control-label col-lg-1">Activo:</label>
					<div class="col-lg-2">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{$perfil->activo ? "checked" : "" }}>
					</div>

				</div>

				<hr>
				<h5>Modulos</h5>
				<div class="form-group">
					<div v-for="modulo in modulos" class="col-lg-1 checkbox">
						  <label><input type="checkbox" :value="modulo.modulo" @click="updateModulo(modulo.modulo,$event)">@{{modulo.modulo}}</label>
					</div>

				</div>
				<!-- box-body -->
				<div class="box-body">
					<!-- table -->
					<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Modulo</th>
								<th class="text-center">Controlador</th>
								<th class="text-center">accion</th>
								<th class="text-center">Acceso</th>
							</tr>
						</thead>
						<tbody>
								<tr v-for="(acceso,key) in accesos" @click="updateAcceso(acceso.id)" :class="[acceso.access ? 'success':'danger']">
									<th class="text-center">@{{key}}</th>
									<td class="text-center">@{{acceso.nombre}}</td>
									<td class="text-center">@{{acceso.modulo}}</td>
									<td class="text-center">@{{acceso.controller}}</td>
									<td class="text-center">@{{acceso.action}}</td>
									<td class="text-center">
										<input type="checkbox" :checked="acceso.access">
							  		</td>
								</tr>
						</tbody>
					</table>
					<!-- /table -->
				</div>
				<!-- /box-body -->

				<!-- Items -->
				<select style="display: none;"  name="items[]" multiple>
					<option v-for="item in accesos" selected>
						@{{item}}
					</option>
				</select>
				<!-- /items -->
			</form>
			<!-- /form-horizontal -->
		</div>
		<!-- /box-body -->

		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="create" class="btn pull-right">Modificar</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->
@endsection

@section('scripts')

<script>
	var modulos = Object.values({!!$modulos!!});
	var accesos = Object.values({!!$accesos!!});
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/config/editPerfilAcceso.js')}}"></script>
@endsection
