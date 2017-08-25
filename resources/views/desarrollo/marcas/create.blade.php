@extends('layouts.master')

@section('content')

<div class="box box-solid box-default">

	<div class="box-header text-center">
      <h4>Crear Marca</h4>
  </div>
  <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" method="post" action="{{route('guardarMarca')}}">
			{{ csrf_field() }}

      <div class="form-group">
        <label for="inputCodigo" class="control-label col-md-2">Codigo:</label>
        <div class="col-md-2">
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
          <input type="text" class="form-control" id="inputDescripcion" name="descripcion" placeholder="Nombre de la Marca..." value="{{Input::old('descripcion')}}" required>
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
          <select class="form-control selectpicker" data-live-search="true" name="familia" required>
						<option value="">Familias...</option>
						@foreach ($familias as $familia)
							<option value="{{$familia->id}}" {{Input::old('familia') == $familia->id ? "selected" : ""}}>{{$familia->descripcion}}</option>
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

			  <label class="control-label col-lg-2" >Lleva IABA:</label>
			  <div class="col-sm-1">
				<input type="checkbox" class="form-control" name="iaba" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('iaba') ? "checked" : "" }}>
			  </div>

				<label for="inputTipo" class="control-label col-sm-2" >Venta Nacional:</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="nacional" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('nacional') ? "checked" : "" }}>
				</div>

				<label for="inputTipo" class="control-label col-sm-2" >Activo:</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ Input::old('activo') ? "checked" : "" }}>
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
	<script src="{{asset('js/includes/select2.js')}}"></script>
@endsection
