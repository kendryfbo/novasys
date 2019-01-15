@extends('layouts.masterCalidad')


@section('content')
	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h4>Editar Documento Sistema Gestión Calidad</h4>
		</div>
	<div class="box-body text-center">
<form method="post" id="update" enctype="multipart/form-data" action="{{route('actualizarDocsPDF', $docs_PDF->id)}}">
{{ csrf_field() }}

		<div class="form-group">
  		<label class="control-label col-md-2">Título : </label>
  		<div class="col-md-6">
			<input type="text" class="form-control" name="titulo" placeholder="Escriba aquí" value="{{$docs_PDF->titulo}}" required>
  		</div>
		</div>
	  		@if ($errors->has('titulo'))
		  		<div class="has-error col-sm-offset-2">
			  		@foreach ($errors->get('titulo') as $error)
						<span class="help-block">{{$error}}</span>
			  		@endforeach
		  		</div>
	  		@endif

		<br><br>

			<div class="form-group">
			<label class="control-label col-md-2">Código : </label>
			<div class="col-md-2">
			<input type="text" class="form-control" name="codigo" placeholder="" value="{{$docs_PDF->codigo}}"required>
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

							   @foreach ($areaUsers as $areaUser)
								 <option value="{{$areaUser->id}}" seleected>{{$areaUser->descripcion}}</option>
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

				   <br><br>

				   <div class="form-group">
				   <label class="control-label col-md-2">Revisión : </label>
				   <div class="col-md-2">
				   <input type="text" class="form-control" name="revision" placeholder="" value="{{$docs_PDF->revision}}" required>
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
				   	 <input type="date" class="form-control" name="fecha_ult_rev" value="{{ $docs_PDF->fecha_ult_rev }}" required>
				      </div>
				    </div>

				   	   @if ($errors->has('fecha_ult_rev'))
				   		   <div class="has-error col-sm-offset-2">
				   			   @foreach ($errors->get('fecha_ult_rev') as $error)
				   				 <span class="help-block">{{$error}}</span>
				   			   @endforeach
				   		   </div>
				   	   @endif

					<br><br>

				   <div class="form-group">
				   <label class="col-sm-2 control-label" >Archivo PDF : </label>
				   <div class="text-left"><a href="../../../{{$docs_PDF->ruta_directorio}}" target="_blank" title="Click aquí para ver archivo actual">Ver Archivo Actual</a></div>
				   <div class="col-sm-4">
				    <br>
				   <input type="file" class="form-control" name="ruta_directorio" placeholder="" value="{{$docs_PDF->ruta_directorio}}" required>
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
	<div class="box-footer">
		<button form="update" class="btn btn-default pull-right" type="submit">Editar</button>
	</div>
	</div>


	</div>
@endsection
