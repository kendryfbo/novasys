@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Premezcla</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarProduccionPremezcla')}}">

				{{ csrf_field() }}

		        <h5>Datos</h5>

		        <!-- form-group -->
		        <div class="form-group">

				  <label class="control-label col-lg-1">Premezcla:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="text" name="premezcla" value="{{$prodPremezcla->premezcla->descripcion}}" readonly>
				  </div>
				  <label class="control-label col-lg-1">Batch:</label>
				  <div class="col-lg-1">
					  <input class="form-control input-sm" type="number" min="1" step="1" name="cantBatch" value="{{$prodPremezcla->cant_batch}}" readonly>
				  </div>

		        </div>
		        <!-- /form-group -->
			</form>
			<!-- /form -->
	    </div>
	    <!-- /box-body -->

	    <!-- box-footer -->
	    <div class="box-footer">

      		<h5>Detalle</h5>

 		<!--<div style="overflow-y: scroll;max-height:200px;border:1px solid black;">-->
      <div>
        <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

          <thead>

            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">cantidad</th>
              <th class="text-center">Existencia</th>
            </tr>

          </thead>

          <tbody>
			@foreach ($prodPremezcla->detalles as $item)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center">{{$item->insumo->codigo}}</td>
					<td class="text-center">{{$item->insumo->descripcion}}</td>
					<td class="text-right">{{$item->cantidad}}</td>
					<td class="{{ $item->existencia >= $item->cantidad ? 'success text-right':'danger text-right' }}">{{$item->existencia}}</td>
				</tr>
			@endforeach

			<tr>
				<th class="text-right active" colspan="3">TOTAL:</th>
				<th class="text-right active">{{$prodPremezcla->detalles->sum('cantidad')}}</th>
				<th class="text-right active">{{$prodPremezcla->detalles->sum('existencia')}}</th>
			</tr>
          </tbody>

        </table>

      </div>

    </div>
    <!-- /box-footer -->
	<!-- box-footer -->
	<div class="box-footer">
		<button form="create" class="btn btn-default pull-right" type="submit" {{$prodPremezcla->disponible ? '':'disabled'}}>Descontar</button>
	</div>
	<!-- /box-footer -->
  </div>
  <!-- /box -->
@endsection

@section('scripts')
<script>
</script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
