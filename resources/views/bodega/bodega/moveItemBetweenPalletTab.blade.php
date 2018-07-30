<!-- Modal -->
<div id="moveItemBetweenPallet" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Trasladar Pallet</h4>

            </div>

            <div class="modal-body">

                <!-- /form-->
                <form id="formTrasladarPallet" class="form-horizontal" action="{{@route('guardarMovEntrePallet')}}" method="post">

                    {{ csrf_field() }}
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-2">Posicion Actual:</label>
                        <div class="col-lg-2">
                            <input class="form-control input-sm" type="text" :value="posicion.bloque +'-'+posicion.columna+'-'+posicion.estante" readonly>
                        </div>

                        <label class="control-label col-lg-1">Pallet:</label>
                        <div class="col-lg-2">
                            <input class="form-control input-sm" type="text" :value="palletOne.numero" readonly>
                            <input class="form-control input-sm" type="hidden" name="palletOneID" :value="palletOne.id">
                        </div>
                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-1">Producto:</label>
                        <div class="col-lg-6">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" name="palletDetalleID" v-model="palletDetalleID" @change="loadExistencia">
                                <option value=""></option>
                                <option v-for="detalle in palletOne.detalles" :value="detalle.id">@{{detalle.producto.descripcion +'- Cantidad: '+ detalle.cantidad}}</option>
                            </select>
                        </div>
                        <label class="control-label col-lg-1">Cantidad:</label>
                        <div class="col-lg-2">
                            <input class="form-control input-sm" type="text" name="cantidad" v-model="cantidad" required>
                        </div>
                    </div>
                    <!-- /form-group -->
                    <hr>
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-1">Bodega:</label>
                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="bodegaID" @change="loadPosiciones">
                                <option value=""></option>
                                <option v-for="bodega in bodegas" :value="bodega.id">@{{bodega.descripcion}}</option>
                            </select>
                        </div>

                        <label class="control-label col-lg-2">Posicion Nueva:</label>
                        <div class="col-lg-2">
                            <select class="selectpicker" data-width="100%" data-live-search="true" data-style="btn-sm btn-default" v-model="newPosicionID" @change="getPallet">
                                <option value=""></option>
                                <option v-for="posicion in posiciones" :value="posicion.id">@{{posicion.bloque +'-'+posicion.columna+'-'+posicion.estante}}</option>
                            </select>
                        </div>

                        <label class="control-label col-lg-1">Pallet:</label>
                        <div class="col-lg-2">
                            <input class="form-control input-sm" type="text" :value="palletTwo.numero" readonly>
                            <input class="form-control input-sm" type="hidden" name="palletTwoID" :value="palletTwo.id" readonly>
                        </div>

                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">


                    </div>
                    <!-- /form-group -->

                </form>
                <!-- /form-->

            </div>

            <div class="modal-footer">
                <button form="formTrasladarPallet" v-if="posicion && newPosicionID && palletTwo && cantidad > 0 && cantidad <= existencia" type="submit" class="btn btn-default">Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>

</div>
