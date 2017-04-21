@extends('layouts.master')


@section('content')

<div class="container box">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Familia</h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{route('guardarFamilia')}}">
		{{ csrf_field() }}

	    <div class="box-body">
	        <div class="form-group">
	          <label for="inputCodigo" class="col-sm-2 control-label">Codigo:</label>
	          <div class="col-sm-2">
	            <input type="text" class="form-control" id="inputCodigo" name="codigo" placeholder="Codigo">
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
	            <input type="text" class="form-control" id="inputDescripcion" name="descripcion" placeholder="Nombre de la familia">
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
	            <input type="text" class="form-control" id="inputTipo" name="tipo" placeholder="Materia prima, Producto terminado">
	          </div>
	        </div>
			@if ($errors->has('tipo'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('tipo') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif
	     </div>
	      <!-- /.box-body -->
	      <div class="box-footer col-sm-10">
	        <button type="submit" class="btn btn-primary pull-right">Crear</button>
	      </div>
	      <!-- /.box-footer -->
    </form>
  </div>

@endsection