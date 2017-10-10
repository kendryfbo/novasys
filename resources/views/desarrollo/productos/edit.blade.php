@extends('layouts.master')


@section('content')

<div id="vue-app" class="box box-solid box-default">

	<div class="box-header text-center">
      <h3 class="box-title">Modificar Producto</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('actualizarProducto',['producto' => $producto->id])}}">
			{{ csrf_field() }}

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2" >Codigo:</label>
					<div class="col-sm-4">
						<input type="text" v-model='codigo' class="form-control" name="codigo" placeholder="Codigo de Producto..." value="{{ $producto->codigo }}" readonly required>
					</div>
					@if ($errors->has('codigo'))
						@component('components.errors.validation')
							@slot('errors')
								{{$errors->get('codigo')[0]}}
							@endslot
						@endcomponent
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" >Descripcion:</label>
					<div class="col-sm-6">
						<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ $producto->descripcion }}" readonly required>
					</div>
					@if ($errors->has('descripcion'))
						@component('components.errors.validation')
							@slot('errors')
								{{$errors->get('descripcion')[0]}}
							@endslot
						@endcomponent
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Marca:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default" name="marca" v-model="marca" @change="updateDescripcion" required>
								<option value="">Seleccionar Marca...</option>
								@foreach ($marcas as $marca)
									<option value="{{$marca->id}}">{{$marca->descripcion}}</option>
								@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Formato:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default" name="formato" v-model="formato" @change="formatChange" required>
								<option value="">Seleccionar Formato...</option>
							@foreach ($formatos as $formato)
								<option value="{{$formato->id}}">{{$formato->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">

					<label class="control-label col-sm-2">Sabor:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-default" name="sabor" v-model="sabor" @change="updateDescripcion" required>
								<option value="">Seleccionr Sabor...</option>
							@foreach ($sabores as $sabor)
								<option value="{{$sabor->id}}">{{$sabor->descripcion}}</option>
							@endforeach
			            </select>
					</div>

				</div>
				<div class="form-group">

					<label class="control-label col-sm-2">Vida Util:</label>
					<div class="col-sm-2">
						<div class="input-group">
							<input class="form-control" type="number" min="1" step="any" class="form-control" name="vida_util" placeholder="Vida util ..." value="{{ $producto->vida_util }}" required>
							<span class="input-group-addon">Meses</span>
						</div>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-lg-2">Peso Bruto:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" step='0.01' value='0.00' placeholder='0.00' v-model='peso_bruto' class="form-control" name="peso_bruto" placeholder="Peso Bruto..." value="{{$producto->peso_bruto}}" required>
							<span class="input-group-addon">kg</span>
						</div>
					</div>

					<label class="control-label col-lg-1">Volumen:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" min="0" step="any" v-model='volumen' class="form-control" name="volumen" placeholder="Volumen..." value="{{$producto->volumen}}" required>
							<span class="input-group-addon">m<sup>3</sup></span>
						</div>
					</div>

					<label class="control-label col-lg-1">Peso Neto:</label>
					<div class="col-lg-2">
						<div class="input-group">
							<input class="form-control" type="number" step='0.01' value='0.00' placeholder='0.00' class="form-control" name="peso_neto" v-model="peso_neto" placeholder="Peso Neto..." value="{{$producto->peso_neto}}" required>
							<span class="input-group-addon">kg</span>
						</div>
					</div>

				</div>

				<div class="form-group">

					<label class="control-label col-sm-2">Activo:</label>
					<div class="col-sm-4">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $producto->activo ? "checked" : "" }} >
					</div>

				</div>

			</div>
		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer">
	 	<button type="submit" form="create" class="btn pull-right">Modificar</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script>
		var codigo = "{!!$producto->codigo!!}";
		var descripcion = "{!!$producto->descripcion!!}";
		var marca = {!!$producto->marca_id!!};
		var formato = {!!$producto->formato_id!!};
		var formatos = {!!$formatos!!};
		var sabor = {!!$producto->sabor_id!!};
		var peso_bruto = {!!$producto->peso_bruto!!};
		var peso_neto = {!!$producto->peso_neto!!};
		var volumen = {!!$producto->volumen!!};
	</script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/productoEdit.js')}}"></script>
@endsection
