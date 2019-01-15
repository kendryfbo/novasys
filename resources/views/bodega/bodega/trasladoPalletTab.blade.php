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
                <form id="formTrasladarPallet" class="form-horizontal" action="{{@route('cambiarPosicionPallet')}}" method="post">

                    {{ csrf_field() }}
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-2">Posicion Actual:</label>
                        <div class="col-lg-2">
                            <input class="form-control input-sm" type="text" name="descripcion" :value="posicion.bloque +'-'+posicion.columna+'-'+posicion.estante" readonly>
                            <input class="form-control input-sm" type="hidden" name="posicion_ant" :value="posicion.id">
                        </div>

                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-2">Bodega:</label>
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

                        <label class="control-label col-lg-2">Posicion Nueva:</label>
                        <div class="col-lg-2">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="posicion_nueva" v-model="newPosicionID" >
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
                <button form="formTrasladarPallet" v-if="posicion && newPosicionID" type="submit" class="btn btn-default">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
