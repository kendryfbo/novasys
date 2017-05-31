@extends('layouts.master2')


@section('content')
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Editar Vendedor</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">
			<!-- form -->
			<form  id="edit" method="post" action="{{ route('vendedores.update', ['vendedor' => $vendedor->id])}}">

				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<!-- form-horizontal -->
				<div class="form-horizontal">

					<div class="form-group">
						<label class="control-label col-sm-2" >R.U.T:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="rut" placeholder="Rut del Vendedor..." value="{{ $vendedor->rut }}" pattern=".{5,10}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Nombre:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="nombre" placeholder="nombre del Vendedor..." value="{{ $vendedor->nombre }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" >Iniciales:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="iniciales" placeholder="Iniciales del Vendedor..." value="{{ $vendedor->iniciales }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Activo:</label>
						<div class="col-sm-4">
							<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $vendedor->activo ? "checked" : "" }}>
						</div>
					</div>

				</div>
				<!-- /form-horizontal -->
			</form>
			<!-- /form -->
		</div>
		<!-- /box-body -->
		<!-- box-footer -->
		<div class="box-footer">
   	 		<button type="submit" form="edit" class="btn pull-right">Editar</button>
   	 	</div>
		<!-- /box-footer -->
	</div>
	<!-- /box -->

@endsection
