@extends('layouts.masterOperaciones')

@section('content')
<style>
.custom {
width: 40px !important;
}
</style>
	<!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Bodegas</h4>
		</div>

		<div class="box-body">

			<div class="container">
					@foreach ($posiciones as $posicion)

						@if ($posicion->columna === 1)
							<div class="btn-group">
						@endif
							@if ($posicion->status_id === 1)
								<button class="btn btn-sm btn-default custom" type="button" disabled name="button">{{ $posicion->columna . '-' . $posicion->estante }}</button>
							@elseif ($posicion->status_id === 2)
								<button class="btn btn-sm btn-success custom" type="button"  name="button">{{ $posicion->columna . '-' . $posicion->estante }}</button>
							@elseif ($posicion->status_id === 3)
								<button class="btn btn-sm btn-danger custom" type="button"  name="button">{{ $posicion->columna . '-' . $posicion->estante }}</button>
							@elseif ($posicion->status_id === 4)
								<button class="btn btn-sm btn-warning custom" type="button"  name="button">{{ $posicion->columna . '-' . $posicion->estante }}</button>
							@else
								<button class="btn btn-sm btn-default custom" type="button" name="button">{{ $posicion->columna . '-' . $posicion->estante }}</button>
							@endif

						@if ($columnas === $posicion->columna)
							</div>
							<br>
						@endif

					@endforeach
			</div>
		</div>

	</div>
@endsection

@section('scripts')
	<script>
		bloques = {!!$bloques!!}
	</script>
	<script src="{{asset('js/customDataTable.js')}}"></script>
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/bodega/Show.js')}}"></script>
@endsection
