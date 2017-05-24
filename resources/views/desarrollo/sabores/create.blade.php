@extends('layouts.master')


@section('content')

<div class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Sabor</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" method="post" action="{{route('guardarSabor')}}">
				{{ csrf_field() }}

			<div class="form-group">
	          <label for="inputDescripcion" class="col-sm-2 control-label" >Descripcion:</label>

	          <div class="col-sm-8">
	            <input type="text" class="form-control" id="inputDescripcion" name="descripcion" placeholder="Sabor..." value="{{Input::old('descripcion')}}" required autofocus>
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
	          <label for="inputDescripcion" class="col-sm-2 control-label" >Descripcion en Ingles:</label>

	          <div class="col-sm-8">
	            <input type="text" class="form-control" id="inputDescripcion" name="descrip_ing" placeholder="Sabor en Ingles..." value="{{Input::old('descrip_ing')}}" required>
	          </div>
	        </div>

			@if ($errors->has('descrip_ing'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('descrip_ing') as $error)
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
