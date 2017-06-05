@extends('layouts.master')


@section('content')

<div id="vue-app" class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Modificar Insumo</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('actualizarInsumo', ['insumo' => $insumo->id])}}">
			{{ csrf_field() }}

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2" >Codigo:</label>
					<div class="col-sm-4">
						<input type="text" v-model='codigo' class="form-control" name="codigo" placeholder="Codigo de Insumo..." value="{{ $insumo->codigo }}" readonly required>
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
						<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ $insumo->descripcion }}" required>
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
					<label class="control-label col-sm-2">Familia:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="familia" v-model="familia" @change="updateDescripcion" required>
							<option value="">Seleccionar Familia...</option>
							@foreach ($familias as $familia)
								<option value="{{$familia->id}}" {{ $insumo->familia_id == $familia->id ? "selected" : "" }}>{{$familia->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Unidad:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="unidad" v-model="unidad" required>
								<option value="">Seleccionar Unidad...</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad->unidad}}" {{ $insumo->unidad_med == $unidad->unidad ? "selected" : "" }}>{{$unidad->descripcion}}</option>
								@endforeach
			            </select>
					</div>
				</div>
			</div>
			<div class="form-inline col-sm-offset-1">

				<div class="form-group">
					<label>Stock Min. :</label>
					<input type="number" class="form-control" name="stock_min" step="1" min="1" value="{{ $insumo->stock_min }}" required>
				</div>
				<div class="form-group">
					<label>Stock Max. :</label>
					<input type="number" class="form-control" name="stock_max" step="1" min="1" value="{{ $insumo->stock_max }}" required>
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
	<script src="{{asset('js/desarrollo/premezcla.js')}}"></script>
@endsection
