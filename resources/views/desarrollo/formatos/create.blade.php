@extends('layouts.master')


@section('content')

<div id="vue-app" class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Formato</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('guardarFormato')}}">
			{{ csrf_field() }}

			<div class="form-horizontal">
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
			</div>
			<br>
			<div class="form-inline col-sm-offset-1">

				<div class="form-group">
					<label>Peso:</label>
					<input type="number" class="form-control" name="peso" v-model="peso" @keyup="updateDescripcion" value="{{ Input::old('peso')}}" step="any" required>
				</div>
				<div class="form-group">
					<label>Unidad:</label>
					<select class="selectpicker" name="unidad" data-live-search="true" v-model="unidad" @change="updateDescripcion" id="tipo-select" required>
							<option value="">Unidades...</option>
						@foreach ($unidades as $unidad)
							<option value="{{$unidad->unidad}}" {{Input::old('unidad') === $unidad->unidad ? "selected" : ""}}>{{$unidad->unidad}}</option>
						@endforeach
		            </select>
				</div>
				<div class="form-group">
					<label>Sobres:</label>
					<input type="number" class="form-control" name="sobre" v-model="sobre" @keyup="updateDescripcion" step="1" min="1" value="{{ Input::old('sobre')}}" required>
				</div>
				<div class="form-group">
					<label>display:</label>
					<input type="number" class="form-control" name="display" v-model="display" @keyup="updateDescripcion" step="1" min="1" value="{{ Input::old('display')}}" required>
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
	 <div class="box-footer col-sm-10">
	 	<button type="submit" form="create" class="btn pull-right">Crear</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/formato.js')}}"></script>
@endsection
