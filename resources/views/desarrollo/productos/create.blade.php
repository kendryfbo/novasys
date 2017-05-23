@extends('layouts.master')


@section('content')

<div id="vue-app" class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Producto</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('guardarProducto')}}">
			{{ csrf_field() }}

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2" >Codigo:</label>
					<div class="col-sm-4">
						<input type="text" v-model='codigo' class="form-control" name="codigo" placeholder="Codigo de Producto..." value="{{ Input::old('codigo') ? Input::old('codigo') : "" }}" readonly required>
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
						<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : '' }}" readonly required>
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
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="marca" v-model="marca" @change="updateDescripcion" id="tipo-select" required>
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
						<select class="form-control selectpicker" data-live-search="true" name="formato" v-model="formato" @change="updateDescripcion" id="tipo-select" required>
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
						<select class="form-control selectpicker" data-live-search="true" name="sabor" v-model="sabor" @change="updateDescripcion" id="tipo-select" required>
								<option value="">Seleccionar Sabor...</option>
							@foreach ($sabores as $sabor)
								<option value="{{$sabor->id}}">{{$sabor->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
			</div>
			<div class="form-inline col-sm-offset-1">
				<div class="form-group">
					<label style=" padding-right: 25px">Peso Bruto:</label>
					<div class="input-group" style=" padding-right: 25px">
						<input class="form-control" type="number" min="0" step="any" v-model='peso_bruto' class="form-control" name="peso_bruto" placeholder="Peso Bruto..." value="{{ Input::old('peso_bruto') ? Input::old('peso_bruto') : "" }}" required>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>
				<div class="form-group">
					<label class="">Volumen:</label>
					<input class="form-control" type="number" min="0" step="any" v-model='volumen' class="form-control" name="volumen" placeholder="Volumen..." value="{{ Input::old('volumen') ? Input::old('volumen') : "" }}" reqired>
				</div>
			</div>
			<br>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Activo:</label>
					<div class="col-sm-4">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
					</div>
				</div>
			</div>


		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer col-sm-8">
	 	<button type="submit" form="create" class="btn pull-right">Crear</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/producto.js')}}"></script>
@endsection
