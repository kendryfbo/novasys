@extends('layouts.master')


@section('content')

<div id="vue-app" class="box box-solid box-default">

	<div class="box-header text-center">
      <h3 class="box-title">Modificar Reproceso</h3>
    </div>
    <!-- /.box-header -->

	<!-- box-body -->
	<div class="box-body">
		<!-- form start -->
		<form id="create" method="post" action="{{route('actualizarReproceso',['reproceso' => $reproceso->id])}}">
			{{ csrf_field() }}

			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2" >Codigo:</label>
					<div class="col-sm-4">
						<input type="text" v-model='codigo' class="form-control" name="codigo" placeholder="Codigo de Reproceso..." value="{{ $reproceso->codigo }}" readonly required>
					</div>
					@if ($errors->has('codigo'))
						@component('components.errors.validation')
							@slot('errors')
								{{$errors->get('codigo')[0]}}
							@endslot
						@endcomponent
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" >Descripcion:</label>
					<div class="col-sm-6">
						<input type="text" v-model='descripcion' class="form-control" name="descripcion" placeholder="Descripcion de Producto..." value="{{ $reproceso->descripcion }}" readonly required>
					</div>
					@if ($errors->has('descripcion'))
						@component('components.errors.validation')
							@slot('errors')
								{{$errors->get('descripcion')[0]}}
							@endslot
						@endcomponent
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Familia:</label>
					<div class="col-sm-6">
						<input type="hidden" class="form-control" name="familia" value="{{$familia->id}}" readonly required>
						<input type="text" class="form-control"  value="{{$familia->descripcion}}" readonly required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Marca:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="marca" v-model="marca" @change="updateDescripcion" required>
								<option value="">Seleccionar Marca...</option>
								@foreach ($marcas as $marca)
									<option value="{{$marca->id}}">{{$marca->descripcion}}</option>
								@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Sabor:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" name="sabor" v-model="sabor" @change="updateDescripcion" required>
								<option value="">Seleccionar Sabor...</option>
							@foreach ($sabores as $sabor)
								<option value="{{$sabor->id}}">{{$sabor->descripcion}}</option>
							@endforeach
			            </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Formato:</label>
					<div class="col-sm-6">
						<select class="form-control selectpicker" data-live-search="true" data-style="btn-default" name="formato" v-model="formato" @change="updateDescripcion" required>
								<option value="">Seleccionar Formato...</option>
								@foreach ($formatos as $formato)
									<option value="{{$formato->id}}">{{$formato->descripcion}}</option>
								@endforeach
			            </select>
					</div>
				</div>
			</div>
			<br>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Activo:</label>
					<div class="col-sm-4">
						<input type="checkbox" name="activo" data-toggle="toggle" data-on="Si" data-off="No" data-size="small" {{ $reproceso->activo ? "checked" : "" }}>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<button type="submit" form="create" class="btn btn-default pull-right">Modificar</button>
	</div>
	<!-- /.box-footer -->
</div>
@endsection

@section('scripts')
	<script>
		var codFamilia = "{!! $familia->codigo !!}";
		$('select[name=marca]').val({!!$reproceso->marca->id!!});
		$('select[name=sabor]').val({!!$reproceso->sabor->id!!});
		$('select[name=formato]').val("{!!$reproceso->formato_id!!}");
		var formatos ={!! $formatos !!};
	</script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/desarrollo/reprocesoEdit.js')}}"></script>
@endsection
