var app = new Vue ({

    el: '#vue-app',

    data: {
        bodega: bodega,
        bloques: bloques,
        bloque: '',
        estantes: [],
        status: '',
        statusAll: [],
        selected: false,
        posicion_id: '',
        posicion: '',
        pallet: '',
        palletNumForFind: '',
        palletPos: '',
        addItemToPalletURL: addItemToPalletURL,
        crearEgrManualDePalletURL: crearEgrManualDePalletURL,
        bodegaConsultURL : bodegaConsultURL,
        bloquearPosURL : bloquearPosURL,
        desbloquearPosURL : desbloquearPosURL,
        findPalletPosURL: findPalletPosURL,
    },

    methods: {

        getBloques: function() {

            var url =bodegaConsultURL;

			axios.post(url,{
                bodegaID: this.bodega.id
            })
			.then(response => this.loadBloque(response.data))
			.catch(error => this.handleError(error))

        },

        loadBloque: function(data) {
            this.bloques = data;
            this.estantes = this.bloques[this.bloque];

        },

        changeBloque: function() {

            this.getBloques();
        },

        blockPosition: function() {

            var url =bloquearPosURL;

			axios.post(url,{
                posicionID: this.posicion_id
            })
			.then(response => this.getBloques())
			.catch(error => this.handleError(error))
        },

        unBlockPosition: function() {

            var url =desbloquearPosURL;

			axios.post(url,{
                posicionID: this.posicion_id
            })
			.then(response => this.getBloques())
			.catch(error => this.handleError(error))
        },

        selectedPos: function(posicion) {

            this.opcion = '';
            this.getCondicion(posicion.id);
            this.getPallet(posicion.id);
            this.posicion_id = posicion.id;
            this.posicion = posicion;
            this.status = posicion.status_id;
            this.selected = true;
            trasladoPallet.posicion = posicion; // instancia de trasladoPallet
            moveItemBetweenPallet.posicion = posicion; // instancia de trasladoPallet
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
            moveItemBetweenPallet.palletOne = this.pallet;
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

            } else if (status == 5){

                return 'btn-primary';
            }
        },

        findPalletPos: function() {

            var url =findPalletPosURL;

			axios.post(url,{
                palletNum: this.palletNumForFind,
                bodegaID: this.bodega.id
            })
			.then(response => this.getPalletPos(response.data))
			.catch(error => this.handleError(error))
        },

        getPalletPos: function(data) {

            this.palletPos = data.bloque+'-'+data.columna+'-'+data.estante;
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
