	@extends('layouts.masterInforme')

	@section('content')
		<!-- box -->
		<div id="vue-app" class="box box-solid box-default">
			<!-- box-header -->
			<div class="box-header text-center">
				<h4>Ventas Mercado Internacional </h4>
			</div>


			<!-- /box-header -->
			<div class="box-body">
				@if (session('status'))
					@component('components.panel')
						@slot('title')
							{{session('status')}}
						@endslot
					@endcomponent
				@endif
			</div>

			<!-- box-body -->
			<div class="box-body">


				<div class="form_group" id="curve_chart" style="width: auto; height: 400px"></div>

				<div class="form-group form-group-sm">

					<label class="control-label col-sm-1">2019:</label>
					<div class="col-sm-1">
						<input type="checkbox" name="" value="" checked>
					</div>
					<label class="control-label col-sm-1">2018:</label>
					<div class="col-sm-1">
						<input type="checkbox" name="" value="" checked>
					</div>
					<label class="control-label col-sm-1">2017:</label>
					<div class="col-sm-1">
						<input type="checkbox" name="" value="" checked>
					</div>

				</div>

			</div>
			<!-- /box-body -->
	</div>

	@endsection

@section('scripts')
<script>

	var data = {!!json_encode($data)!!};
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{asset('vue/vue.js')}}"></script>
<script src="{{asset('js/informes/cierreMes/cierreMesIntlChart.js')}}"></script>
<script src="{{asset('js/customDataTable.js')}}"></script>
@endsection
