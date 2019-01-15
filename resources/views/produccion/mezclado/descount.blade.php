@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Produccion Mezclado</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarDescProdMezclado')}}">

				{{ csrf_field() }}

		        <h5>Datos</h5>

		        <!-- form-group -->
		        <div class="form-group">

				  <label class="control-label col-lg-1">Bodega:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="hidden" name="bodega" value="{{$bodega->id}}" readonly>
					  <input class="form-control input-sm" type="text" value="{{$bodega->descripcion}}" readonly>
				  </div>

		        </div>
		        <!-- /form-group -->
		        <!-- form-group -->
		        <div class="form-group">

				  <label class="control-label col-lg-1">Numero:</label>
				  <div class="col-lg-1">
					  <input class="form-control input-sm" type="hidden" name="prodMezclado" value="{{$prodMezclado->id}}" readonly>
					  <input class="form-control input-sm" type="text" value="{{$prodMezclado->numero}}" readonly>
				  </div>
				  <label class="control-label col-lg-1">Reproceso:</label>
				  <div class="col-lg-3">
					  <input class="form-control input-sm" type="text" value="{{$prodMezclado->formula->reproceso->descripcion}}" readonly>
				  </div>
				  <label class="control-label col-lg-1">Batch:</label>
				  <div class="col-lg-1">
					  <input class="form-control input-sm" type="number" min="1" step="1" name="cantBatch" value="{{$prodMezclado->cant_batch}}" readonly>
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
				<th colspan="6" class="text-center">Premezcla</th>
			</tr>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">cantidad</th>
              <th class="text-center">Existencia</th>
              <th class="text-center">Faltante</th>
            </tr>

          </thead>

          <tbody>
				<tr class="{{ $prodMezclado->premExistencia >= $prodMezclado->cant_batch ? '':'danger' }}">
					<td class="text-center">1</td>
					<td class="text-center">{{$prodMezclado->formula->premezcla->codigo}}</td>
					<td class="text-center">{{$prodMezclado->formula->premezcla->descripcion}}</td>
					<td class="text-right">{{$prodMezclado->cant_batch}}</td>
					<td class="text-right">{{$prodMezclado->premExistencia}}</td>
					<td class="text-right">{{($prodMezclado->cant_batch - $prodMezclado->premExistencia) >= 0 ? $prodMezclado->cant_batch - $prodMezclado->premExistencia : 0}}</td>
				</tr>
          </tbody>

        </table>

      </div>
      <div>
        <table class="table table-condensed table-hover table-bordered table-custom display nowrap" cellspacing="0" width="100%">

          <thead>
			<tr>
				<th colspan="6" class="text-center">Mezclado</th>
			</tr>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Codigo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">cantidad</th>
              <th class="text-center">Existencia</th>
              <th class="text-center">Faltante</th>
            </tr>

          </thead>

          <tbody>
			@foreach ($prodMezclado->detalles as $item)
				<tr  class="{{ $item->existencia >= $item->cantidad ? '':'danger' }}">
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center">{{$item->insumo->codigo}}</td>
					<td class="text-center">{{$item->insumo->descripcion}}</td>
					<td class="text-right">{{abs(round($item->cantidad,2))}}</td>
					<td class="text-right">{{$item->existencia}}</td>
					<td class="text-right">{{(abs(round($item->cantidad,2)) - $item->existencia) >= 0 ? abs(round($item->cantidad,2)) - $item->existencia : 0}}</td>
				</tr>
			@endforeach
          </tbody>

        </table>

      </div>

    </div>
    <!-- /box-footer -->
	<!-- box-footer -->
	<div class="box-footer">
		<button form="create" class="btn btn-default pull-right" type="submit" {{$prodMezclado->disponible ? '':'disabled'}}>Descontar</button>
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
