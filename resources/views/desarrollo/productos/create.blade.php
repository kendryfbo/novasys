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
						<input type="text" v-model='codigo' class="form-control" name="descripcion" placeholder="Codigo de Producto..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : "" }}" readonly>
					</div>
					@if ($errors->has('descripcion'))
						<div class="has-error col-sm-offset-2">
							@foreach ($errors->get('descripcion') as $error)
							  <span class="help-block">{{$error}}</span>
							@endforeach
						</div>
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" >Descripcion:</label>
					<div class="col-sm-4">
						<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : "" }}" readonly>
					</div>
					@if ($errors->has('descripcion'))
						<div class="has-error col-sm-offset-2">
							@foreach ($errors->get('descripcion') as $error)
							  <span class="help-block">{{$error}}</span>
							@endforeach
						</div>
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Marca:</label>
					<div class="col-sm-4">
						<select class="form-control" name="marca" v-model="marca" @change="updateDescripcion" id="tipo-select">
								<option value="">Seleccionar Marca...</option>
							@foreach ($marcas as $marca)
								<option value="{{$marca->codigo}}" {{Input::old('marca') === $marca->id ? "selected" : ""}}>{{$marca->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Formato:</label>
					<div class="col-sm-4">
						<select class="form-control" name="marca" v-model="formato" @change="updateDescripcion" id="tipo-select">
								<option value="">Seleccionar Formato...</option>
							@foreach ($formatos as $formato)
								<option value="{{$formato->id}}" {{Input::old('formato') === $formato->id ? "selected" : ""}}>{{$formato->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">$sabor:</label>
					<div class="col-sm-4">
						<select class="form-control" name="marca" v-model="sabor" @change="updateDescripcion" id="tipo-select">
								<option value="">Seleccionr Sabor...</option>
							@foreach ($sabores as $sabor)
								<option value="{{$sabor->id}}" {{Input::old('sabor') === $sabor->id ? "selected" : ""}}>{{$sabor->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Activo:</label>
				<div class="col-sm-4">
					<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
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
	<script src="{{asset('js/includes/select2.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/producto.js')}}"></script>
@endsection
