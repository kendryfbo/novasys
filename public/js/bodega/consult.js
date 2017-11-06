var app = new Vue ({

    el: '#vue-app',

    data: {
        bloques: bloques,
        bloque: '',
        estantes: [],
        status: '',
        statusAll: [],
        selected: false,
        posicion_id: '',
        posicion: '',
        pallet: [],
    },

    methods: {

        changeBloque: function() {

            this.estantes = this.bloques[this.bloque];

        },
        selectedPos: function(posicion) {

            this.opcion = '';
            this.getCondicion(posicion.id);
            this.getPallet(posicion.id);
            this.posicion_id = posicion.id;
            this.posicion = posicion;
            this.status = posicion.status_id;
            this.selected = true;
        },

        nextEstante: function() {

            console.log('estante');
            this.estante++;
        },

        storeData: function() {

            this.storeStatus();
        },

        storeStatus: function() {

            if (!this.status) {

                return;
            }

            status = this.status;
            posicion = this.posicion_id;
            var url = '/bodega/posicion/status';

			axios.post(url,{
                status_id: status,
                posicion_id: posicion
            })
			.then(response => this.updateStatusPos())
			.catch(error => this.handleError(error))
        },

        getCondicion: function() {

        },

        getPallet: function(id) {

            if (!id) {

                return;
            }

            posicion = id;
            var url = '/bodega/posicion/pallet';

			axios.post(url,{
                posicion_id: posicion
            })
			.then(response => this.loadPallet(response.data))
			.catch(error => this.handleError(error))
        },

        loadPallet: function(data) {


            this.pallet = data;

            if (!this.pallet) {

                this.pallet = [];
            }
        },

        updateStatusPos: function() {


        },

        handleError: function(error) {

            console.log(error);
			alert(error);
        },

        statusClass: function(status) {

            if (status == 1) {

                return 'btn-default';

            } else if (status == 2) {

                return 'btn-success';

            } else if (status == 3) {

                return 'btn-danger';

            } else if (status == 4){

                return 'btn-warning';
            }
        },

        clearSelection: function() {

            this.status = '';
            this.posicion = [];
            this.selected = false;
        }

    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    }

});
