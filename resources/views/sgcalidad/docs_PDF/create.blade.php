@extends('layouts.masterCalidad')

@section('content')

<div class="box box-solid box-default">

	<div class="box-header text-center">
      <h4>Ingresar Documento de Calidad</h4>
  </div>
  <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{route('guardarDocumentosCalidad')}}">
			{{ csrf_field() }}

			<div class="form-group">
			  <label class="control-label col-md-2">Título : </label>
			  <div class="col-md-6">
				<input type="text" class="form-control" name="titulo" placeholder="Escriba aquí" value="{{Input::old('titulo')}}" required>
			  </div>
			</div>

				  @if ($errors->has('titulo'))
					  <div class="has-error col-sm-offset-2">
						  @foreach ($errors->get('titulo') as $error)
							<span class="help-block">{{$error}}</span>
						  @endforeach
					  </div>
				  @endif

	 <div class="form-group">
	 <label class="control-label col-md-2">Código : </label>
	 <div class="col-md-2">
	 <input type="text" class="form-control" name="codigo" placeholder="" value="{{Input::old('codigo')}}"required>
	 </div>


		@if ($errors->has('codigo'))
		 <div class="has-error col-sm-offset-2">
		  @foreach ($errors->get('codigo') as $error)
		 <span class="help-block">{{$error}}</span>
		  @endforeach
		 </div>
		@endif


        <label class="control-label col-md-2">Área : </label>
        <div class="col-md-2">
			<select class="form-control selectpicker" data-live-search="true" name="area" required>
						<option value="">Seleccione el Área</option>
						@foreach ($areaUsers as $areaUser)
						  <option value="{{$areaUser->id}}"> {{$areaUser->descripcion}} </option>
					  @endforeach
		  </select>
        </div>
      </div>

			@if ($errors->has('area'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('area') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

			<div class="form-group">
			<label class="control-label col-md-2">Revisión : </label>
			<div class="col-md-2">
			<input type="text" class="form-control" name="revision" placeholder="" value="{{Input::old('revision')}}" required>
			</div>


			   @if ($errors->has('revision'))
				<div class="has-error col-sm-offset-2">
				 @foreach ($errors->get('revision') as $error)
				<span class="help-block">{{$error}}</span>
				 @endforeach
				</div>
			   @endif


			   <label class="control-label col-md-2">Fecha Ult. Rev. : </label>
			   <div class="col-md-2">
				 <input type="date" class="form-control" name="fecha_ult_rev" value="{{Input::old('fecha_ult_rev')}}" required>
			   </div>
			 </div>

				   @if ($errors->has('fecha_ult_rev'))
					   <div class="has-error col-sm-offset-2">
						   @foreach ($errors->get('fecha_ult_rev') as $error)
							 <span class="help-block">{{$error}}</span>
						   @endforeach
					   </div>
				   @endif


		<div class="form-group">
        <label class="col-sm-2 control-label" >Archivo PDF : </label>
        <div class="col-sm-5">
          <input type="file" class="form-control" name="ruta_directorio" placeholder="" value="{{Input::old('ruta_directorio')}}" required>
        </div>
      </div>

			@if ($errors->has('ruta_directorio'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('ruta_directorio') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif
	</div>
	</form>
 	<!-- /.box-body -->
	 <div class="box-footer">
	 	<button type="submit" form="create" class="btn btn-default pull-right">Ingresar</button>
	 </div>
	  <!-- /.box-footer -->
</div>
@endsection
