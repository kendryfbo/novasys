<!-- Modal -->
<div id="findPalletPos" class="modal fade" role="dialog">

    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pallet info</h4>

            </div>

            <div class="modal-body">

                <!-- /form-->
                <form class="form-horizontal">

                    <!-- form-group -->
                    <div class="form-group text-left">

                        <label class="control-label col-sm-2">Pallet:</label>
    					<div class="col-sm-4">
    						<input id="palletNumForFind" class="form-control input-sm" type="number" name="palletNumForFind" v-model="palletNumForFind" @keyup.enter="findPallet" autofocus>
    					</div>
                        <div class="col-sm-5 text-left">
                            <label class="control-label">@{{msg}}</label>
                        </div>
                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-2">Bodega:</label>
                        <div class="col-lg-6">
                            <input class="form-control input-sm" name="numero" type="text" :value="bodegaDescrip" required readonly>
                        </div>

                    </div>
                    <!-- /form-group -->
                    <!-- form-group -->
                    <div class="form-group">

                        <label class="control-label col-lg-2">Posicion:</label>
            			<div class="col-lg-4">
    						<input class="form-control input-sm" name="medida" type="text" :value="posicionDescrip" required readonly>
            			</div>

                    </div>
                    <!-- /form-group -->

                </form>
                <!-- /form-->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearInputs">Close</button>
            </div>
        </div>

    </div>
</div>
