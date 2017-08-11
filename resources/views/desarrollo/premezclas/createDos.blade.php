@extends('layouts.master')


@section('content')

<div id="vue-app" class="container box box-gray">

	<div class="box-header with-border">
      <h3 class="box-title">Crear Premezcla</h3>
    </div>
    <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('guardarPremezcla')}}">
			{{ csrf_field() }}

			<div class="form-horizontal">

				<div class="form-group">
					<label class="control-label col-sm-2">Seleccione Producto:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="producto" @change="" required>
								@foreach ($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->descripcion}}</option>
								@endforeach
			            </select>
					</div>
				</div>


			</div>


		</form>
     </div>
	 <!-- /.box-body -->
	 <div class="box-footer col-sm-8">
	 	<button type="submit" form="create" class="btn pull-right">Crear</button>
	 </div>
	  <!-- /.box-footer -->
  </div>
@endsection

@section('scripts')
	<script>
	var codFamilia = "";
		var unidades =0;
	</script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/premezcla.js')}}"></script>
@endsection
