@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Pallets pendientes por Almacenar</h4>
		</div>
		<!-- /box-header -->

        <!-- /box-header -->
		<div class="box-body">
			@if (session('status'))
				@component('components.panel')
					@slot('title')
						{{session('status')}}
					@endslot
				@endcomponent
			@endif
			<div class="btn-group pull-right">
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Creacion de Pallet <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{route('crearPalletMP')}}">MP / Insumo</a></li>
                  <li><a href="{{route('crearPalletPR')}}">Premezcla</a></li>
                  <li><a href="#">Reproceso</a></li>
                  <li><a href="{{route('crearPalletPT')}}">Producto Terminado</a></li>
                </ul>
              </div>
              <a type="button" href="{{route('ingresoPallet')}}" class="btn btn-primary">Almacenar Pallet</a>
            </div>
		</div>
		<!-- box-body -->

		<!-- box-body -->
		<div class="box-body">

			<!-- table -->
			<table id="data-table" class="table table-hover table-bordered table-custom table-condensed display nowrap compact" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Numero</th>
						<th class="text-center">Fecha</th>
						<th class="text-center">Tamaño</th>
						<th class="text-center">Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($pallets as $pallet)
						<tr>
							<th class="text-center">{{$loop->iteration}}</th>
							<td class="text-center">
								<a href="{{route('verPallet',['pallet' => $pallet->id])}}" target="_blank"><strong>{{$pallet->numero}}</strong></a>
								</td>
							<td class="text-center">{{$pallet->created_at}}</td>
							<td class="text-center">{{$pallet->medida->descripcion}}</td>
							<td class="text-center">
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-pencil-square-o fa-sm" aria-hidden="true"></i>
									</button>
									<button type="submit" class="btn btn-default btn-sm">
										<i class="fa fa-trash-o fa-sm" aria-hidden="true"></i>
									</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- /table -->
        </div>
        <!-- /box-body -->

@endsection
@section('scripts')
	<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
