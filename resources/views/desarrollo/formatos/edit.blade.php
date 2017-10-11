@extends('layouts.master')

@section('content')

<div id="vue-app" class="box box-solid box-default">

	<div class="box-header text-center">
      <h4>Editar Formato</h4>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="edit" class="form-horizontal" method="post" action="{{route('actualizarFormato',['formato' => $formato->id])}}">
			{{ csrf_field() }}

			<div class="form-group form-group-sm">

				<label class="control-label col-sm-1" >Descripcion :</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name="descripcion" placeholder="Descripcion de Formato..." value="{{ $formato->descripcion }}" required autofocus>
				</div>

			</div>

			<div class="form-group form-group-sm">

				<label class="control-label col-sm-1">Peso Uni. :</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input type="number" class="form-control" name="peso_uni" value="{{ $formato->peso_uni }}" step="any" required>
						<span class="input-group-addon">g</span>
					</div>
				</div>

				<label class="control-label col-sm-1">Peso Neto:</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input type="number" class="form-control" name="peso_neto" value="{{ $formato->peso_neto }}" step="any" required>
						<span class="input-group-addon">Kg</span>
					</div>
				</div>

			</div>


			<div class="form-group form-group-sm">
				<label class="control-label col-sm-1">Activo:</label>
				<div class="col-sm-4">
					<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $formato->activo ? 'checked' : '' }}>
				</div>

			</div>

		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer">
	 	<button type="submit" form="edit" class="btn btn-default pull-right">Modificar</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection
