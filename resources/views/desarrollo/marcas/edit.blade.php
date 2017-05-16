@extends('layouts.master')

@section('content')

<div class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Marca</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="edit" class="form-horizontal" method="post" action="{{route('actualizarMarca',['marca' => $marca->id])}}">
				{{ csrf_field() }}

	        <div class="form-group">
	          <label for="inputCodigo" class="col-sm-2 control-label">Codigo:</label>
	          <div class="col-sm-2">
	            <input type="text" class="form-control" id="inputCodigo" name="codigo" placeholder="Codigo" value="{{$marca->codigo}}" required disabled>
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
	            <input type="text" class="form-control" id="inputDescripcion" name="descripcion" placeholder="Nombre de la familia" value="{{$marca->descripcion}}" required>
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

	          <label for="inputTipo" class="col-sm-2 control-label" >Familia:</label>
			  <div class="col-sm-8">
	            <select class="form-control selectpicker" data-live-search="true" name="familia" id="tipo-select" required>
						<option value="">Familias...</option>
					@foreach ($familias as $familia)
						<option value="{{$familia->id}}" {{$familia->id == $marca->familia_id ? "selected" : ""}}>{{$familia->descripcion}}</option>
					@endforeach
	            </select>
	          </div>

	        </div>
			@if ($errors->has('familia'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('tipo') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

			<div class="form-group">
			  <label for="inputTipo" class="col-sm-2 control-label" >Lleva IABA:</label>
			  <div class="col-sm-8">
				<input type="checkbox" class="control-label" name="iaba" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $marca->iaba ? "checked" : "" }}>
			  </div>
			</div>
			<div class="form-group">
			  <label for="inputTipo" class="col-sm-2 control-label" >Venta Nacional:</label>
			  <div class="col-sm-8">
				<input type="checkbox" class="control-label" name="nacional" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $marca->nacional ? "checked" : "" }}>
			  </div>
			</div>
			<div class="form-group">
			  <label for="inputTipo" class="col-sm-2 control-label" >Activo:</label>
			  <div class="col-sm-8">
				<input type="checkbox" class="control-label" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $marca->activo ? "checked" : "" }}>
			  </div>
			</div>

		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer col-sm-10">
	 	<button type="submit" form="edit" class="btn pull-right">Modificar</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script src="{{asset('js/includes/select2.js')}}"></script>
@endsection
