@extends('layouts.masterOperaciones')

@section('content')

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#trasladoPallet">Open Modal</button>

<!-- Modal -->
<div id="trasladoPallet" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Trasladar Pallet</h4>

            </div>

            <div class="modal-body">

                <!-- /form-->
                <form class="form-horizontal" action="" method="post">

                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-1">Posicion:</label>
                        <div class="col-lg-5">
                            <input class="form-control input-sm" type="text" name="descripcion" value="POSICION" readonly>
                        </div>

                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-1">Bodega:</label>
                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="bodega" v-model="bodegaID" @change="loadPosiciones">
                                <option value=""></option>
                                <option v-for="bodega in bodegas" :value="bodega.id">@{{bodega.descripcion}}</option>
                            </select>
                        </div>

                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-1">Posicion:</label>
                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="posicion" v-model="posicionID" >
                                <option value=""></option>
                                <option v-for="posicion in posiciones" :value="posicion.id">@{{posicion.bloque +'-'+posicion.columna+'-'+posicion.estante}}</option>
                            </select>
                        </div>

                    </div>
                    <!-- /form-group -->

                </form>
                <!-- /form-->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')

    <script src="{{asset('vue/vue.js')}}"></script>
    <script src="{{asset('js/bodega/trasladoPallet.js')}}"></script>
@endsection
