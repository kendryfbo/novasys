var app = new Vue ({

    el: '#vue-app',

    data: {
        bloques: bloques,
        bloque: '',
        tiposCondicion: tiposCondicion,
        tipoCond: '',
        opciones: '',
        opcion: '',
        estantes: [],
        status: '',
        statusAll: statusAll,
        selected: false,
        posicion_id: '',
        posicion: ''
    },

    methods: {

        changeBloque: function() {

            this.estantes = this.bloques[this.bloque];

        },
        selectedPos: function(posicion) {

            this.opcion = '';
            this.getCondicion(posicion.id);
            this.posicion_id = posicion.id;
            this.posicion = posicion;
            this.status = posicion.status_id;
            this.selected = true;
        },

        getCondicion: function(id) {

            var url = '/bodega/getCondicion/' + id;

			axios.get(url)
			.then(response => this.loadCondicion(response.data))
			.catch(error => this.handleError(error))
        },

        loadCondicion: function(data) {

            this.tipoCond = data.tipo_id;
            this.getOpciones(data.opcion_id);
        },

        nextEstante: function() {

            console.log('estante');
            this.estante++;
        },

        getOpciones : function(opcion) {

            if (!this.tipoCond) {

                return;
            }

            var url = '/bodega/getOpciones/' + this.tipoCond;

			axios.get(url)
			.then(response => this.loadOpciones(response.data,opcion))
			.catch(error => this.handleError(error))
        },

        loadOpciones: function(data,opcion) {

            this.opciones = data;

            if (opcion) {
                this.opcion = opcion;
                $('.selectpicker').selectpicker('refresh');
            }
        },

        storeData: function() {

            this.storeStatus();
            this.storeCondicion();
        },

        storeCondicion: function() {

            if((this.tipoCond) && (!this.opcion)) {

                return;
            }

            tipo = this.tipoCond;
            opcion = this.opcion;
            posicion = this.posicion_id;
            var url = '/bodega/posicion/condicion';

			axios.post(url,{
                tipo_id: tipo,
                opcion_id: opcion,
                posicion_id: posicion
            })
			.then(response => this.clearSelection())
			.catch(error => this.handleError(error))
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
            this.opcion = '';
            this.tipoCond = '';
            this.posicion = [];
            this.selected = false;
        }

    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    }

});
