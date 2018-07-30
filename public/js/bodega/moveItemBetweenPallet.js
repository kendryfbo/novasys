var moveItemBetweenPallet = new Vue({

    el: '#moveItemBetweenPallet',
    data: {
        bodegas: [],
        posiciones: [],
        bodegaID: '',
        newPosicionID: '',
        posicion: '',
        palletOne: [],
        palletTwo: [],
        palletDetalleID: '',
        cantidad: '',
        existencia: '',
    },

    methods: {

        loadPosiciones: function() {

            for (var i = 0; i < this.bodegas.length; i++) {

                if (this.bodegas[i].id == this.bodegaID) {

                    this.posiciones = this.bodegas[i].posiciones;
                    return;
                }
            }
        },

        getBodegasWithPos: function() {

            var url = '/api/bodega/posConPallet';

			axios.get(url)
			.then(response => this.loadBodegas(response.data))
			.catch(error => this.handleError(error))
        },

        getPallet: function() {


            posicion = this.newPosicionID;
            var url = '/bodega/posicion/pallet';

			axios.post(url,{
                posicion_id: posicion
            })
			.then(response => this.loadPallet(response.data))
			.catch(error => this.handleError(error))
        },
        loadPallet: function(data) {


            this.palletTwo = data;
            if (!this.palletTwo) {
                this.palletTwo = [];
            }
        },

        loadExistencia: function() {

            for (var i = 0; i < this.palletOne.detalles.length; i++) {
                
                if (this.palletOne.detalles[i].id == this.palletDetalleID) {

                    this.existencia = this.palletOne.detalles[i].cantidad;
                    return;
                }
            }
        },

        loadBodegas: function(data){

            this.bodegas = data;
        },

        handleError: function(error) {

            alert(error);
        }


    },

    mounted: function() {

        this.getBodegasWithPos();
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
