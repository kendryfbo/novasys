@extends('layouts.masterOperaciones')

@section('content')

  <!-- box -->
	<div id="vue-app" class="box box-solid box-default">
		<!-- box-header -->
		<div class="box-header text-center">
			<h4>Editar Termino de Proceso</h4>
		</div>
		<!-- /box-header -->
		<!-- box-body -->
		<div class="box-body">

			@if ($errors->any())

				@foreach ($errors->all() as $error)

					@component('components.errors.validation')

            @slot('errors')

              {{$error}}

						@endslot

					@endcomponent

				@endforeach

			@endif

			<!-- form -->
			<form class="form-horizontal"  id="create" method="post" action="{{route('guardarTerminoProceso')}}">

				{{ csrf_field() }}

                <h5>Documento</h5>

				<!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Producto:</label>
                    <div class="col-lg-4">
                      <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="prod_id" v-model="prodId" @change="updateVidaUtil" required>
                        <option value=""></option>
						<option v-for="producto in productos" :value="producto.id">@{{producto.descripcion}}</option>

                      </select>
                    </div>

                    <label class="control-label col-lg-1">Vida Util:</label>
                    <div class="col-lg-1">
						<input class="form-control input-sm" name="vida_util" type="number" v-model="vidaUtil" required disabled>
                    </div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

        			<label class="control-label col-lg-1">Fecha Prod.:</label>
        			<div class="col-lg-2">
        				<input class="form-control input-sm" type="date" name="fecha_prod" v-model="fechaProd" @change="updateVenc" required>
        			</div>

        			<label class="control-label col-lg-1">Fecha Venc.:</label>
        			<div class="col-lg-2">
        				<input class="form-control input-sm" type="date" name="fecha_venc" v-model="fechaVenc" @change="updateNumLote" required readonly>
        			</div>


                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

        			<label class="control-label col-lg-1">Turno:</label>
        			<div class="col-lg-5">

                            <div v-for="turno in turnos" class="radio-inline">
                                <label><input type="radio" name="turno" @change="updateNumLote" value="turno">@{{turno}}</label>
                            </div>

        			</div>


                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Producidas:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="producidas" type="number" value="{{$terminoProceso->producidas}}" min="1" required>
                    </div>

                    <label class="control-label col-lg-1">Rechazadas:</label>
                    <div class="col-lg-1">
                        <input class="form-control input-sm" name="rechazadas" type="number" value="{{$terminoProceso->rechazadas}}" min="0" required>
                    </div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Maquina:</label>
                    <div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="maquina" v-model="maquina" @change="updateNumLote" required>
                          <option value=""> </option>
            							@foreach ($maquinas as $maquina)

            								<option {{$maquina == $terminoProceso->maquina ? 'selected':''}} value="{{$maquina}}">{{$maquina}}</option>

            							@endforeach
                        </select>
                    </div>
                    <label class="control-label col-lg-1">Operador:</label>
                    <div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="operador" v-model="operador" @change="updateNumLote" required>
                          <option value=""> </option>
            							@foreach ($operadores as $operador)

            								<option {{$operador == $terminoProceso->operador ? 'selected':''}} value="{{$operador}}">{{$operador}}</option>

            							@endforeach
                        </select>
                    </div>
                    <label class="control-label col-lg-1">Codigo:</label>
                    <div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="codigo" v-model="codigo" @change="updateNumLote">
                          <option value=""> </option>
            							@foreach ($codigos as $codigo)

            								<option {{$codigo == $terminoProceso->codigo ? 'selected':''}} value="{{$codigo}}">{{$codigo}}</option>

            							@endforeach
                        </select>
                    </div>
                    <label class="control-label col-lg-1">Batch:</label>
                    <div class="col-lg-1">
                        <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="batch" v-model="batch" @change="updateNumLote" required>
                          <option value=""> </option>
            							@foreach ($batchs as $batch)

            								<option {{$batch == $terminoProceso->batch ? 'selected':''}} value="{{$batch}}">{{$batch}}</option>

            							@endforeach
                        </select>
                    </div>

                </div>
                <!-- /form-group -->

                <!-- form-group -->
                <div class="form-group">

                    <label class="control-label col-lg-1">Nº Lote:</label>
                    <div class="col-lg-2">
                        <input class="form-control input-sm" name="lote" v-model="lote" type="text" required readonly>
                    </div>

                </div>
                <!-- /form-group -->

            </form>
            <!-- /form -->

        </div>
        <!-- /box-body -->

        <!-- box-footer -->
        <div class="box-footer">
            <button form="create" class="btn btn-default pull-right" type="submit">Crear</button>
        </div>
        <!-- /box-footer -->
    </div>
    <!-- /box -->


@endsection

@section('scripts')
	<script>
		var productos = {!!$productos!!};
		var prodId = {!!$terminoProceso->fecha_prod!!};
		var fechaProd = {!!$terminoProceso->fecha_prod!!};
		var fechaVenc = {!!$terminoProceso->fecha_venc!!};
		var turnos = {!!json_encode($turnos)!!};
		var turno = '';
		var lote = '';
	</script>
	{{--
	<script>
		var productos = {!!$productos!!};
		var fechaProd = {!!$terminoProceso->fecha_prod!!};
		var prodId = {!!$terminoProceso->prod_id!!};
		var turno = {!!$terminoProceso->turno!!};
		var lote = {!!$terminoProceso->lote!!};
	</script>
	--}}
	<script src="{{asset('vue/vue.js')}}"></script>
	<script src="{{asset('js/produccion/editTerminoProceso.js')}}"></script>
@endsection
