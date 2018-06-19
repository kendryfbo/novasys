@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Envasado</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarDescProdEnvasado',['id' => $prodEnvasado->id])}}">

				{{ csrf_field() }}

		        <h5>Datos</h5>

		        <!-- form-group -->
		        <div class="form-group">

				  <label class="control-label col-lg-1">Bodega:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="text" name="bodega" value="{{$bodega->descripcion}}" readonly>
				  </div>

		        </div>
		        <!-- /form-group -->
		        <!-- form-group -->
		        <div class="form-group">

				  <label class="control-label col-lg-1">Producto:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="text" name="envasado" value="{{$prodEnvasado->formula->producto->descripcion}}" readonly>
				  </div>
				  <label class="control-label col-lg-1">Batch:</label>
				  <div class="col-lg-1">
					  <input class="form-control input-sm" type="number" min="1" step="1" name="cantBatch" value="{{$prodEnvasado->cant_batch}}" readonly>
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
			  	<th colspan="5" class="text-center">PRODUCTO MEZCLADO</th>
			  </tr>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">cantidad</th>
              <th class="text-center">Existencia</th>
            </tr>

          </thead>

          <tbody>
				<tr>
					<td class="text-center">1</td>
					<td class="text-center">{{$prodEnvasado->formula->reproceso->codigo}}</td>
					<td class="text-center">{{$prodEnvasado->formula->reproceso->descripcion}}</td>
					<td class="text-right">{{$prodEnvasado->cant_rpr}}</td>
					<td class="{{ $prodEnvasado->reprExistencia >= $prodEnvasado->cant_rpr ? 'success text-right':'danger text-right' }}">{{$prodEnvasado->reprExistencia}}</td>
				</tr>
          </tbody>
          <thead>
			  <tr>
			   <th colspan="5" class="text-center">ENVASADO</th>
			 </tr>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">cantidad</th>
              <th class="text-center">Existencia</th>
            </tr>

          </thead>

          <tbody>
			@foreach ($prodEnvasado->detalles as $item)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center">{{$item->insumo->codigo}}</td>
					<td class="text-center">{{$item->insumo->descripcion}}</td>
					<td class="text-right">{{abs(round($item->cantidad,2))}}</td>
					<td class="{{ $item->existencia >= $item->cantidad ? 'success text-right':'danger text-right' }}">{{$item->existencia}}</td>
				</tr>
			@endforeach

			<tr>
				<th class="text-right active" colspan="3">TOTAL:</th>
				<th class="text-right active">{{abs(round($prodEnvasado->detalles->sum('cantidad'),2))}}</th>
				<th class="text-right active">{{abs(round($prodEnvasado->detalles->sum('existencia'),2))}}</th>
			</tr>
          </tbody>

        </table>

      </div>

    </div>
    <!-- /box-footer -->
	<!-- box-footer -->
	<div class="box-footer">
		<button form="create" class="btn btn-default pull-right" type="submit" {{$prodEnvasado->disponible ? '':'disabled'}}>Descontar</button>
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