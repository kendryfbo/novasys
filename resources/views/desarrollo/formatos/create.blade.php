@extends('layouts.master')


@section('content')

<div id="vue-app" class="box box-solid box-default">

	<div class="box-header text-center">
      <h4>Crear Formato</h4>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
  <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" method="post" action="{{route('guardarFormato')}}">

			{{ csrf_field() }}

			<div class="form-group">
				<label class="control-label col-sm-2" >Descripcion:</label>
				<div class="col-sm-4">
					<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Formato..." value="{{ Input::old('descripcion') ? Input::old('descripcion') : "" }}" required readonly>
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

				<label class="control-label col-lg-2">Unidad:</label>
				<div class="col-lg-2">
					<select class="selectpicker" name="unidad" data-live-search="true" v-model="unidad" @change="updateDescripcion" required>
						<option value="">Unidades...</option>
						@foreach ($unidades as $unidad)
							<option value="{{$unidad->unidad}}" {{Input::old('unidad') === $unidad->unidad ? "selected" : ""}}>{{$unidad->unidad}}</option>
						@endforeach
					</select>
				</div>

			</div>

			<div class="form-group">

				<label class="control-label col-lg-2">display:</label>
				<div class="col-lg-2">
					<input type="number" class="form-control" name="display" v-model="display" @keyup="updateDescripcion" step="1" min="1" value="{{ Input::old('display')}}" required>
				</div>

				<label class="control-label col-lg-1">Sobres:</label>
				<div class="col-lg-2">
					<input type="number" class="form-control" name="sobre" v-model="sobre" @keyup="updateDescripcion" step="1" min="1" value="{{ Input::old('sobre')}}" required>
				</div>

				<label class="control-label col-lg-1">Peso:</label>
				<div class="col-lg-2">
					<div class="input-group">
						<input type="number" class="form-control" name="peso" v-model="peso" @keyup="updateDescripcion" value="{{ Input::old('peso')}}" step="any" required>
						<span class="input-group-addon">g</span>
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
	 <div class="box-footer">
	 	<button type="submit" form="create" class="btn btn-default pull-right">Crear</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/formato.js')}}"></script>
@endsection
