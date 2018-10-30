@extends('layouts.masterCalidad')

@section('content')
<div class="box box-solid box-default">

	<div class="box-header text-center">
      <h4>Ingresar No Conformidad</h4>
  </div>
  <!-- /.box-header -->
	<!-- box-body -->
    <div class="box-body">
		<!-- form start -->
		<form id="create" class="form-horizontal" method="post" action="{{route('guardarNoConformidad')}}">
			{{ csrf_field() }}

      <div class="form-group">
        <label class="control-label col-md-2">Título :</label>
        <div class="col-md-7">
          <input type="text" class="form-control" name="titulo" maxlength="190" placeholder="Escriba aquí" value="{{Input::old('titulo')}}" required autofocus>
        </div>
      </div>

			@if ($errors->has('titulo'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('titulo') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

		<div class="form-group">
        <label class="col-sm-2 control-label" >Área en que se Detecta :</label>
        <div class="col-sm-3">
			<select class="form-control selectpicker" data-live-search="true" name="area" required>
  						<option value="0">Seleccione el Área</option>
  						@foreach ($areaUsers as $areaUser)
  						  <option value="{{$areaUser->id}}"> {{$areaUser->descripcion}} </option>
  					  @endforeach
  		  </select>
        </div>


			@if ($errors->has('area'))
				<div class="has-error col-sm-offset-2">
					@foreach ($errors->get('area') as $error)
					  <span class="help-block">{{$error}}</span>
					@endforeach
				</div>
			@endif

			<label class="col-sm-2 control-label" >Fecha Detección :</label>
			<div class="col-sm-2">
			  <input type="date" class="form-control" name="fecha_deteccion" placeholder="" value="{{Input::old('fecha_deteccion')}}" required>
			</div>
		  </div>

				@if ($errors->has('fecha_deteccion'))
					<div class="has-error col-sm-offset-2">
						@foreach ($errors->get('fecha_deteccion') as $error)
						  <span class="help-block">{{$error}}</span>
						@endforeach
					</div>
				@endif

				<div class="form-group">
				<label class="col-sm-2 control-label" >Nombre persona que Detecta :</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" name="persona_detecta" placeholder="" value="{{Input::old('persona_detecta')}}" required>
				</div>
			  </div>

					@if ($errors->has('persona_detecta'))
						<div class="has-error col-sm-offset-2">
							@foreach ($errors->get('persona_detecta') as $error)
							  <span class="help-block">{{$error}}</span>
							@endforeach
						</div>
					@endif

					<div class="form-group">
					<label class="col-sm-2 control-label" >Norma / Proced. / Instructivo :</label>
					<div class="col-sm-7">
					  <input type="text" class="form-control" name="npi" maxlength="190" placeholder="" value="{{Input::old('npi')}}" required>
					</div>
				  </div>

						@if ($errors->has('npi'))
							<div class="has-error col-sm-offset-2">
								@foreach ($errors->get('npi') as $error)
								  <span class="help-block">{{$error}}</span>
								@endforeach
							</div>
						@endif

						<div class="form-group">
						<label class="col-sm-2 control-label" >Cláusula :</label>
						<div class="col-sm-7">
						  <input type="text" class="form-control" name="clausula" maxlength="190" placeholder="" value="{{Input::old('clausula')}}" required>
						</div>
					  </div>

							@if ($errors->has('clausula'))
								<div class="has-error col-sm-offset-2">
									@foreach ($errors->get('clausula') as $error)
									  <span class="help-block">{{$error}}</span>
									@endforeach
								</div>
							@endif

			<div class="box-header text-left">
  			<h5><u>Origen : </u></h5>
			</div>

			<div class="form-group">
			  <label class="control-label col-lg-2" >Auditoría Interna :</label>
			  <div class="col-sm-1">
				<input type="checkbox" class="form-control" name="OAI" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('OAI') ? "checked" : "" }}>
			  </div>

				<label class="control-label col-sm-2" >Reclamo Cliente :</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="ORC" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('ORC') ? "checked" : "" }}>
				</div>

				<label class="control-label col-sm-2" >Proceso :</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="OPR" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('OPR') ? "checked" : "" }}>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Real :</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="ORE" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('ORE') ? "checked" : "" }}>
				</div>
				<label class="control-label col-sm-2" >Potencial :</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="OPO" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('OPO') ? "checked" : "" }}>
				</div>
				<label class="control-label col-sm-2" >Observaciones :</label>
				<div class="col-sm-1">
					<input type="checkbox" class="form-control" name="OBS" data-toggle="toggle" data-on="Sí" data-off="No" data-size="small" {{ Input::old('OBS') ? "checked" : "" }}>
				</div>
			</div>

					<div class="form-group">
					<label class="col-sm-2 control-label" >Detalle de la No Conformidad</label>
					<div class="col-sm-7">
					<textarea class="form-control" name="descripcion" maxlength="599" placeholder="" rows="5" style="overflow:auto;resize:none" value="{{Input::old('descripcion')}}" required></textarea>
					</div>
					</div>
					   @if ($errors->has('descripcion'))
						   <div class="has-error col-sm-offset-2">
							   @foreach ($errors->get('descripcion') as $error)
								 <span class="help-block">{{$error}}</span>
							   @endforeach
						   </div>
					   @endif

					   <div class="form-group">
					   <label class="col-sm-2 control-label" >Solución Sugerida</label>
					   <div class="col-sm-7">
	  			   <textarea class="form-control" name="solucion_sugerida" maxlength="599" placeholder="" rows="5" style="overflow:auto;resize:none"		value="{{Input::old('solucion_sugerida')}}" required></textarea>

					   </div>
					   </div>
					      @if ($errors->has('solucion_sugerida'))
					   	   <div class="has-error col-sm-offset-2">
					   		   @foreach ($errors->get('solucion_sugerida') as $error)
					   			 <span class="help-block">{{$error}}</span>
					   		   @endforeach
					   	   </div>
					      @endif

			<div class="form-group">

			  <label class="col-sm-2 control-label" >Enviar a:</label>
				  <div class="col-sm-7">
				<select class="form-control selectpicker" data-live-search="true" name="para_id" required>
							  <option value="Seleccione Usuario"></option>
							  @foreach ($sendToUsers as $sendToUser)
	  							<option value="{{$sendToUser->id}}"> {{$sendToUser->cargo}} - {{$sendToUser->nombre}} {{$sendToUser->apellido}}</option>
	  						@endforeach
				</select>
			  </div>
			</div>

				  @if ($errors->has('para_id'))
					  <div class="has-error col-sm-offset-2">
						  @foreach ($errors->get('para_id') as $error)
							<span class="help-block">{{$error}}</span>
						  @endforeach
					  </div>
				  @endif

		</form>
 	</div>
 	<!-- /.box-body -->

	 <div class="box-footer">

	 	<button type="submit" form="create" class="btn btn-default pull-right">Ingresar</button>

	 </div>
	  <!-- /.box-footer -->
</div>
@endsection

@section('scripts')
	<script src="{{asset('js/includes/select2.js')}}"></script>
@endsection
