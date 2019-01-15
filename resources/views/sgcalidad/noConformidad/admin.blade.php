
@extends('layouts.masterCalidad')

@section('content')

	<div class="box box-solid box-default">
		<div class="box-header text-center">
			<h3>Administrar No Conformidad</h3>
		</div>
	<div class="box-body text-center">

	<form method="post" id="update" action="{{route('cierreNoConformidad', $noconformidad->id) }}">
	{{ csrf_field() }}

	<div class="form-group">
	<label class="col-sm-2 control-label" >No Conformidad N° : </label>

	<div class="col-sm-2">
	<input type="text" class="form-control" name="noconformidad_id" value="{{$noconformidad->id}}" readonly>
	</div>
	</div>

	@if ($errors->has('noconformidad_id'))
	<div class="has-error col-sm-offset-2">
		@foreach ($errors->get('noconformidad_id') as $error)
		  <span class="help-block">{{$error}}</span>
		@endforeach
	</div>
	@endif

	<div class="form-group">
	<label class="col-sm-2 control-label" >Fecha Detección : </label>
	<div class="col-sm-2">
	<input type="text" class="form-control" name="fecha_deteccion" value="{{ date('d/m/Y', strtotime($noconformidad->fecha_deteccion))}}" readonly>
	</div>
	</div>

	@if ($errors->has('fecha_deteccion'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('fecha_deteccion') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Título : </label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="titulo" value="{{$noconformidad->titulo}}" readonly>
	</div>
	</div>

	@if ($errors->has('titulo'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('titulo') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Estado : </label>
	<div class="col-sm-8">
		<select class="form-control selectpicker" data-live-search="true" name="estadonc" required>
		<option value="{{$noconformidad->estado_id}}">{{$noconformidad->estadonc->descrip}}</option>
		<option value="1">Enviada</option>
		<option value="2">Contestada</option>
		<option value="3">Solucionada</option>
		</select>
	</div>
	</div>

	@if ($errors->has('estadonc'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('estadonc') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Persona que Detecta : </label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="persona_detecta" value="{{$noconformidad->persona_detecta}}" readonly>
	</div>
	</div>

	@if ($errors->has('persona_detecta'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('persona_detecta') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Descripción / Detalle : </label>
	<div class="col-sm-8">
	<textarea class="form-control" name="descripcion" maxlength="899" placeholder="" rows="5" style="overflow:auto;resize:none" readonly>{{$noconformidad->descripcion}}</textarea>

	</div>
	</div>

	@if ($errors->has('descripcion'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('descripcion') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br><br><br><br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Solución Sugerida : </label>
	<div class="col-sm-8">
	<textarea class="form-control" name="solucion_sugerida" maxlength="899" placeholder="" rows="5" style="overflow:auto;resize:none" readonly>{{$noconformidad->solucion_sugerida}}</textarea>
	</div>
	</div>

	@if ($errors->has('solucion_sugerida'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('solucion_sugerida') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br><br><br><br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Análisis de la Causa : </label>
	<div class="col-sm-8">
	<textarea class="form-control" name="analisis_causa" maxlength="899" placeholder="" rows="5" style="overflow:auto;resize:none">{{$noconformidad->analisis_causa}}</textarea>

	</div>
	</div>

	@if ($errors->has('analisis_causa'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('analisis_causa') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br><br><br><br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Acción Propuesta  : </label>
	<div class="col-sm-8">
	<textarea class="form-control" name="accion_propuesta" maxlength="899" placeholder="" rows="5" style="overflow:auto;resize:none">{{$noconformidad->accion_propuesta}}</textarea>

	</div>
	</div>

	@if ($errors->has('accion_propuesta'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('accion_propuesta') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br><br><br><br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Fecha Implementación  : </label>
	<div class="col-sm-8">
	<input type="date" class="form-control" name="fecha_implementacion" value="{{$noconformidad->fecha_implementacion}}" required>
	</div>
	</div>

	@if ($errors->has('fecha_implementacion'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('fecha_implementacion') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Seguimiento Acción  : </label>
	<div class="col-sm-8">
	<textarea class="form-control" name="seguimiento_accion" maxlength="899" placeholder="" rows="5" style="overflow:auto;resize:none">{{$noconformidad->seguimiento_accion}}</textarea>

	</div>
	</div>

	@if ($errors->has('seguimiento_accion'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('seguimiento_accion') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<br><br><br><br><br><br>

	<div class="form-group">
	<label class="col-sm-2 control-label" >Fecha de Cierre  : </label>
	<div class="col-sm-8">
	<input type="date" class="form-control" name="fecha_cierre" value="{{$noconformidad->fecha_cierre}}">
	</div>
	</div>

	@if ($errors->has('fecha_cierre'))
	<div class="has-error col-sm-offset-2">
	  @foreach ($errors->get('fecha_cierre') as $error)
		<span class="help-block">{{$error}}</span>
	  @endforeach
	</div>
	@endif

	<div class="box-footer">
		<button form="update" class="btn btn-default pull-right" type="submit">Administrar No Conformidad</button>
	</div>
	</div>
	</form>

	</div>

@endsection
