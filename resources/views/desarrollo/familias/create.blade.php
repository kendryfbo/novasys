@extends('layouts.master')


@section('content')

<div class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Familia</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" method="post" action="{{route('guardarFamilia')}}">
				{{ csrf_field() }}

	        <div class="form-group">
	          <label for="inputCodigo" class="col-sm-2 control-label">Codigo:</label>
	          <div class="col-sm-2">
	            <input type="text" class="form-control" id="inputCodigo" name="codigo" placeholder="Codigo" value="{{Input::old('codigo')}}" required autofocus>
	          </div>
	        </div>

			@if ($errors->has('codigo'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('codigo') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

			<div class="form-group">
	          <label for="inputDescripcion" class="col-sm-2 control-label" >Descripcion:</label>

	          <div class="col-sm-8">
	            <input type="text" class="form-control" id="inputDescripcion" name="descripcion" placeholder="Nombre de la familia" value="{{Input::old('descripcion')}}" required>
	          </div>
	        </div>

			@if ($errors->has('descripcion'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('descripcion') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

	        <div class="form-group">

	          <label for="inputTipo" class="col-sm-2 control-label" >Tipo:</label>
			  <div class="col-sm-8">
	            <select class="form-control selectpicker" data-live-search="true" name="tipo" id="tipo-select" required>
						<option value="">Tipos de Familias...</option>
					@foreach ($tiposFamilia as $tipo)
						<option value="{{$tipo->id}}" {{Input::old('tipo') == $tipo->id ? "selected" : ""}}>{{$tipo->descripcion}}</option>
					@endforeach
	            </select>
	          </div>

	        </div>
			@if ($errors->has('tipo'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('tipo') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif
			<div class="form-group">
	          <label for="inputTipo" class="col-sm-2 control-label" >activo:</label>
			  <div class="col-sm-2">
	            <input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
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
	<script src="{{asset('js/includes/select2.js')}}"></script>
@endsection
