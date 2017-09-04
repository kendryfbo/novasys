@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Modificar Cliente Nacional</h4>
		</div>
		<!-- /box-header -->
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#cliente">Cliente</a></li>
		  <li><a data-toggle="tab" href="#sucursales">Sucursales</a></li>
		</ul>
		<!-- tab-content -->
		<div class="tab-content">
			<!-- tab-panel -->
  			<div id="cliente" class="tab-pane fade in active">
				<!-- box-body -->
				<div class="box-body">
					<!-- form-horizontal -->
					<form  id="create" class="form-horizontal" method="post" action="{{route('clientesNacionales.update', ['cliente' => $cliente->id])}}">
						{{ method_field('PATCH') }}
						{{ csrf_field() }}

						<div class="form-group">
							<label class="control-label col-lg-1" >Descripcion:</label>
							<div class="col-lg-5">
								<input type="text" class="form-control input-sm" name="descripcion" placeholder="Nombre del Cliente..." value="{{$cliente->descripcion}}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-1" >Direccion:</label>
							<div class="col-lg-6">
								<input type="text" class="form-control input-sm" name="direccion" placeholder="Direccion..." value="{{$cliente->direccion}}" required>
							</div>
						</div>

						<div class="form-group">

							<label class="control-label col-lg-1" >Pais:</label>
							<div class="col-lg-1">
								<select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="pais" required>
									<option value="">Seleccionar pais...</option>
									@foreach ($paises as $pais)
										<option {{$cliente->pais == $pais->nombre ? 'selected':'' }} value="{{$pais->nombre}}">{{$pais->nombre}}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-lg-1" >F. Pago:</label>
							<div class="col-lg-2">
								<select class="selectpicker" data-width="false" data-live-search="true" data-style="btn-sm btn-default" name="formaPago" required>
									<option value="">Seleccionar Forma Pago...</option>
									@foreach ($formasPago as $formaPago)
										<option {{$cliente->fp_id == $formaPago->id ? 'selected':'' }} value="{{$formaPago->id}}">{{$formaPago->descripcion}}</option>
									@endforeach
								</select>
							</div>

							<label class="control-label col-lg-1" >Credito:</label>
							<div class="col-lg-2">
								<input type="number" class="form-control input-sm" name="credito" placeholder="Credito..." value="{{$cliente->credito}}" required>
							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-lg-1" >Giro:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="giro" placeholder="Giro..." value="{{$cliente->giro}}" required>
							</div>

							<label class="control-label col-lg-1" >Zona:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="zona" placeholder="Continente, zona geografica..." value="{{$cliente->zona}}" required>
							</div>

							<label class="control-label col-lg-1" >Idioma:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="idioma" placeholder="idioma..." value="{{$cliente->idioma}}" required>
							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-lg-1">Contacto:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="contacto" placeholder="Persona de Contacto..." value="{{$cliente->contacto}}" required>
							</div>

							<label class="control-label col-lg-1">Cargo:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="cargo" placeholder="Cargo de Persona de Contacto..." value="{{$cliente->cargo}}" required>
							</div>

							<label class="control-label col-lg-1">fono:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="fono" placeholder="Numero de Tlf..." value="{{$cliente->fono}}" required>
							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-lg-1">email:</label>
							<div class="col-lg-2">
								<input type="email" class="form-control input-sm" name="email" placeholder="Email de Persona de Contacto..." value="{{$cliente->email}}" required>
							</div>

							<label class="control-label col-lg-1">fax:</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" name="fax" placeholder="numero de Fax..." value="{{$cliente->fax}}" required>
							</div>

						</div>

						<div class="form-group">
							<label class="control-label col-lg-1">Activo:</label>
							<div class="col-lg-2">
								<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $cliente->activo ? "checked" : "" }}>
							</div>
						</div>

					</form>
					<!-- /form-horizontal -->
				</div>
				<!-- /box-body -->
				<!-- box-footer -->
				<div class="box-footer">
		   	 		<button type="submit" form="create" class="btn pull-right">Crear</button>
		   	 	</div>
				<!-- /box-footer -->
			</div>
			<!-- /tab-panel -->

			<!-- tab-panel -->
  			<div id="sucursales" class="tab-pane fade in">
				<!-- box-body -->
				<div class="box-body">
					<!-- form-horizontal -->
					<div id="create-sucursal" class="form-horizontal">

						<div class="form-group">
							<label class="control-label col-lg-1" >Descripcion:</label>
							<div class="col-lg-3">
								<input type="text" class="form-control input-sm" name="descripcion_suc" v-model="descripcion_suc" placeholder="Descripcion de la Sucursal..." required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-1" >Direccion:</label>
							<div class="col-lg-5">
								<input type="text" class="form-control input-sm" name="direccion_suc" v-model="direccion_suc" placeholder="Direccion de la Sucursal..." required>
							</div>
						</div>

					</div>
					<!-- /form-horizontal -->
				</div>
				<!-- /box-body -->
				<!-- box-footer -->
				<div class="box-footer">
		   	 		<button type="button" form="create-sucursal" class="btn pull-right" v-on:click="insertSucursal">Agregar</button>
		   	 	</div>
				<!-- /box-footer -->
				<!-- box-body -->
				<div class="box-body">
					<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>id</th>
								<th>decripcion</th>
								<th>direccion</th>
								<th class="text-center">Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<td colspan="5" class="text-center" v-if="sucursales <= 0">Tabla Sin Datos...</td>
							<tr v-for="(sucursal,key) in sucursales" @click="loadSucursal(sucursal.id)">
								<th class="text-center" v-text="(key+1)"></th>
								<td>@{{ sucursal.id }}</td>
								<td>@{{ sucursal.descripcion }}</td>
								<td>@{{ sucursal.direccion }}</td>
								<td class="text-center">
									<button class="btn btn-sm" type="button" @click="deleteSucursal(sucursal.id)">
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
<script>
	var cliente_id = {!! $cliente->id !!}
	var sucursales = {!! $cliente->sucursales->toJson() !!}
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/comercial/clienteIntlEdit.js')}}"></script>

@endsection
