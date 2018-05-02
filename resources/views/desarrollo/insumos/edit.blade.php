@extends('layouts.master')


@section('content')

<div id="vue-app" class="box box-solid box-default">

	<div class="box-header text-center">
      <h3 class="box-title">Modificar Insumo</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form class="form-horizontal" id="create" method="post" action="{{route('actualizarInsumo', ['insumo' => $insumo->id])}}">
			{{ csrf_field() }}

			<div class="form-group">
				<label class="control-label col-sm-1" >Codigo:</label>
				<div class="col-sm-2">
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
				<label class="control-label col-sm-1" >Descripcion:</label>
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

				<label class="control-label col-sm-1">Familia:</label>
				<div class="col-sm-3">
					<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="familia" v-model="familia" @change="updateDescripcion" required>
						<option value="">Seleccionar Familia...</option>
						@foreach ($familias as $familia)
							<option value="{{$familia->id}}" {{ $insumo->familia_id == $familia->id ? "selected" : "" }}>{{$familia->descripcion}}</option>
						@endforeach
		            </select>
				</div>

				<label class="control-label col-sm-1">Unidad:</label>
				<div class="col-sm-2">
					<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="unidad" v-model="unidad" required>
						<option value="">Seleccionar Unidad...</option>
						@foreach ($unidades as $unidad)
							<option value="{{$unidad->unidad}}" {{ $insumo->unidad_med == $unidad->unidad ? "selected" : "" }}>{{$unidad->descripcion}}</option>
						@endforeach
					</select>
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-sm-1">Stock Min. :</label>
				<div class="col-sm-1">
					<input type="number" class="form-control" name="stock_min" step="1" min="1" value="{{ $insumo->stock_min }}" required>
				</div>

				<label class="control-label col-sm-1">Stock Max. :</label>
				<div class="col-sm-1">
					<input type="number" class="form-control" name="stock_max" step="1" min="1" value="{{ $insumo->stock_max }}" required>
				</div>

				<label class="control-label col-sm-1">Alerta BOD.:</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input class="form-control" type="number" min="0" step="1" class="form-control" name="alerta_bod" placeholder="1,2,3..." value="{{$insumo->alerta_bod}}" required>
						<span class="input-group-addon">Meses</span>
					</div>
				</div>

			</div>

			<div class="form-group">
				<label class="control-label col-sm-1">Activo:</label>
				<div class="col-sm-4">
					<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $insumo->activo ? "checked" : "" }}>
				</div>
			</div>


		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer">
	 	<button type="submit" form="create" class="btn pull-right">Crear</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/premezcla.js')}}"></script>
@endsection
